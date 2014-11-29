<?php
class HttpProxy
{
	const SUCCESS = 0;				//成功
	const errUrlInvalid = 1;		//非法url
	const errServiceInvalid = 2;	//对端服务不正常
	const errHttpTimeout = 3;		//交互超时，包括连接超时
	const errTooManyRedirects = 4;	//重定向次数过多
	const errTooLargeResponse = 5;	//响应内容过大
	const errResponseErrorPage = 6;	//返回错误页面
	const errNoResponse = 7;		//没有响应包
	const errNoResponseBody = 8;	//响应包中没有body内容
	const errOtherEror = 9;			//其余错误

	protected $curl;
	protected $curl_info;
	protected $curl_options = null;	//curl options

	protected $max_response_size;	//max response body size

	protected $errno;
	protected $errmsg;
	protected $header;
	protected $body;
	protected $body_len;

	private static $instance = null;

	protected function __construct($options = null)
	{
		$user_agent = $options['user_agent'] ? $options['user_agent'] : '';
		$referer = $options['referer'] ? $options['referer'] : '';
        $conn_timeout=$options['conn_timeout'] ? $options['conn_timeout'] : 1000;
        $timeout=$options['timeout'] ? $options['timeout'] : 3000;
        $conn_retry=$options['conn_retry'] ? $options['conn_retry'] : 3;

		$this->reset();

		$this->curl_options = array(
				'follow_location' => false,
				'max_redirs' => 1,
				'conn_retry' => $conn_retry,
				'conn_timeout' => $conn_timeout,
				'timeout' => $timeout,
				'user_agent' => $user_agent,
				'referer' => $referer,
				'encoding' => '',
				'max_response_size' => 512000,	//default is 500k
				);

		$this->setOptions($options);
		
	}

	public static function getInstance($options = null)
	{
		if( self::$instance === null )
		{
			self::$instance = new HttpProxy($options);
		}
		else
		{
			self::$instance->setOptions($options);
		}
		return self::$instance;
	}

	public static function onResponseHeader($curl, $header)
	{
		$proxy = HttpProxy::getInstance();
		$proxy->header .= $header;

		$trimmed = trim($header);
		if( preg_match('/^Content-Length: (\d+)$/i', $trimmed, $matches) )
		{ 
			$content_length = $matches[1];
			if( $content_length > $proxy->max_response_size )
			{
				$proxy->body_len = $content_length;
				return 0;
			}
		} 

		return strlen($header);
	}

	public static function onResponseData($curl, $data)
	{
		$proxy = HttpProxy::getInstance();

		$chunck_len = strlen($data);
		$proxy->body .= $data;
		$proxy->body_len += $chunck_len;

		if( $proxy->body_len + $chunck_len <= $proxy->max_response_size )
		{
			return $chunck_len;
		}
		else
		{
			return 0;
		}
	}

	public function setOptions($options)
	{
		if( is_array($options) )
		{
			//$options + $default_options results in an assoc array with overlaps
			//deferring to the value in $options
			$this->curl_options = $options + $this->curl_options;
		}

		$this->max_response_size = $this->curl_options['max_response_size'];
	}

	public function get($url, $cookie = array())
	{
		$this->reset();

        $cookie = $cookie === 0 ? array() : (empty($cookie) ? $_COOKIE : $cookie);

		extract($this->curl_options);

		$curl = curl_init();
		if( $max_redirs < 1 )
		{
			$max_redirs = 1;
		}

		$curl_opts = array( CURLOPT_URL => $url,
							//CURLOPT_CONNECTTIMEOUT_MS => $conn_timeout,
							//CURLOPT_TIMEOUT_MS => $timeout,
							CURLOPT_USERAGENT => $user_agent,
							CURLOPT_REFERER => $referer,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HEADER => false,
							CURLOPT_FOLLOWLOCATION => $follow_location,
							CURLOPT_MAXREDIRS => $max_redirs,
							CURLOPT_ENCODING => $encoding,
							CURLOPT_WRITEFUNCTION => 'HttpProxy::onResponseData',
							CURLOPT_HEADERFUNCTION => 'HttpProxy::onResponseHeader',
						);

		//mod 20100106: 修复低版本CURL不支持CURLOPT_TIMEOUT_MS的bug;
		if ( defined('CURLOPT_TIMEOUT_MS') && defined('CURLOPT_CONNECTTIMEOUT_MS') ) {
			$curl_opts[CURLOPT_TIMEOUT_MS] = $timeout;
			$curl_opts[CURLOPT_CONNECTTIMEOUT_MS] = $conn_timeout;
		}else {
			$curl_opts[CURLOPT_TIMEOUT] = max($timeout/1000,1);
			$curl_opts[CURLOPT_CONNECTTIMEOUT] = max($conn_timeout/1000,1);
		}

		if( is_array($cookie) && count($cookie) > 0 )
		{
			$cookie_str = '';
			foreach( $cookie as $key => $value )
			{
				$cookie_str .= "$key=$value; ";
			}
			$curl_opts[CURLOPT_COOKIE] = $cookie_str;
        } else {
            $curl_opts[CURLOPT_COOKIE] = $cookie;
        }

		curl_setopt_array($curl, $curl_opts);

		curl_exec($curl);

		$errno = curl_errno($curl);
		$errmsg = curl_error($curl);
		$this->curl_info = curl_getinfo($curl);

		curl_close($curl);

		if( $this->check_http_response($url, $errno, $errmsg) )
		{
			return $this->body;
		}

		return false;
	}

	public function post($url, $params, $cookie = array(), $upload = 0)
	{
		$this->reset();

		extract($this->curl_options);

		$curl = curl_init();
		if( $max_redirs < 1 )
		{
			$max_redirs = 1;
		}

		$curl_opts = array( CURLOPT_URL => $url,
							//CURLOPT_CONNECTTIMEOUT_MS => $conn_timeout,
							//CURLOPT_TIMEOUT_MS => $timeout,
							CURLOPT_USERAGENT => $user_agent,
							CURLOPT_REFERER => $referer,
							CURLOPT_RETURNTRANSFER => true,
							CURLOPT_HEADER => false,
							CURLOPT_ENCODING => $encoding,
							CURLOPT_WRITEFUNCTION => 'HttpProxy::onResponseData',
							CURLOPT_HEADERFUNCTION => 'HttpProxy::onResponseHeader',
							);
		
		//mod 20100106: 修复低版本CURL不支持CURLOPT_TIMEOUT_MS的bug;
		if ( defined('CURLOPT_TIMEOUT_MS') && defined('CURLOPT_CONNECTTIMEOUT_MS') ) {
			$curl_opts[CURLOPT_TIMEOUT_MS] = $timeout;
			$curl_opts[CURLOPT_CONNECTTIMEOUT_MS] = $conn_timeout;
		}else {
			$curl_opts[CURLOPT_TIMEOUT] = max($timeout/1000,1);
			$curl_opts[CURLOPT_CONNECTTIMEOUT] = max($conn_timeout/1000,1);
		}

        $cookie = $cookie === 0 ? array() : (empty($cookie) ? $_COOKIE : $cookie);
		if( is_array($cookie) && count($cookie) > 0 )
		{
			$cookie_str = '';
			foreach( $cookie as $key => $value )
			{
				$cookie_str .= "$key=$value; ";
			}
			$curl_opts[CURLOPT_COOKIE] = $cookie_str;
		}

		curl_setopt_array($curl, $curl_opts);

		$last_url   = $url;
		$redirects  = 0;
		$retries    = 0;

		$post_str = $upload ? $params : http_build_query($params);

		if( $max_redirs == 1 )
		{
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post_str);
			curl_exec($curl);
			$errno = curl_errno($curl);
			$errmsg = curl_error($curl);
			$this->curl_info = curl_getinfo($curl);
		}
		else
		{
			$start_time = microtime(true);
			for( $attempt = 0; $attempt < $max_redirs; $attempt++ )
			{
				curl_setopt($curl, CURLOPT_POSTFIELDS, $post_str);
				curl_exec($curl);
				$errno = curl_errno($curl);
				$errmsg = curl_error($curl);
				$this->curl_info = curl_getinfo($curl);

				//Remove any HTTP 100 headers
				if( ($curl_info['http_code'] == 301 ||
					 $curl_info['http_code'] == 302 ||
					 $curl_info['http_code'] == 307) &&
					preg_match('/Location: ([^\r\n]+)\r\n/si', $this->header, $matches) )
				{
					$new_url = $matches[1];

					//if $new_url is relative path, prefix with domain name
					if( !preg_match('/^http(|s):\/\//', $new_url) &&
						preg_match('/^(http(?:|s):\/\/.*?)\//', $url, $matches) )
					{
						$new_url = $matches[1] . '/' . $new_url;
					}
					$last_url = $new_url;
					curl_setopt($curl, CURLOPT_URL, $new_url);

					//reduce the timeout, but keep it at least 1 or we wind up with an infinite timeout
					
					if ( defined('CURLOPT_TIMEOUT_MS') ) {
						curl_setopt($curl, CURLOPT_TIMEOUT_MS, max($start_time + $timeout - microtime(true), 1)); 
					}else {
						curl_setopt($curl, CURLOPT_TIMEOUT, max(($start_time + $timeout - microtime(true))/1000, 1)); 
					}
					++$redirects;
				}
				elseif( $conn_retry && strlen($this->header) == 0 )
				{
					//probably a connection failure...if we have time, try again...
					$time_left = $start_time + $timeout - microtime(true);
					if( $time_left < 1 )
					{
						break;
					}
					// ok, we've got some time, let's retry
					curl_setopt($curl, CURLOPT_URL, $last_url);
					if ( defined('CURLOPT_TIMEOUT_MS') ) {
						curl_setopt($curl, CURLOPT_TIMEOUT_MS, $time_left);
					}else {
						curl_setopt($curl, CURLOPT_TIMEOUT, max($time_left/1000,1));
					}
					++$retries;
				}
				else
				{
					break; // we have a good response here
				}
			}
		}

		curl_close($curl);

		if( $this->check_http_response($url, $errno, $errmsg) )
		{
			return $this->body;
		}

		return false;
	}

	public function content_type()
	{
		//take content-type field into account first
		if( !empty($this->curl_info['content_type']) &&
			preg_match('#charset=([^;]+)#i', $this->curl_info['content_type'], $matches) )
		{
			return $matches[1];
		}

		return false;
	}

	public function body()
	{
		return $this->body;
	}

	public function cookie()
	{
		if( empty($this->header) )
		{
			return array();
		}

		$new_cookie = array();

		$headers = explode("\n", $this->header);
		foreach( $headers as $item )
		{
			if( strncasecmp($item, 'Set-Cookie:', 11) === 0 )
			{
				$cookiestr = trim(substr($item, 11, -1));
				$cookie = explode(';', $cookiestr);
				$cookie = explode('=', $cookie[0]);

				$cookiename = trim(array_shift($cookie));
				$new_cookie[$cookiename] = trim(implode('=', $cookie));
			}
		}

		return $new_cookie;
	}

	public function errno()
	{
		return $this->errno;
	}

	public function errmsg()
	{
		return $this->errmsg;
	}

	private function check_http_response($url, $errno, $errmsg)
	{
		$url = htmlspecialchars($url, ENT_QUOTES);

		$http_code = $this->curl_info['http_code'];

		if( $errno == CURLE_URL_MALFORMAT ||
			$errno == CURLE_COULDNT_RESOLVE_HOST )
		{
			$this->errno = self::errUrlInvalid;
			$this->errmsg = "The URL $url is not valid.";
		}
		elseif( $errno == CURLE_COULDNT_CONNECT )
		{
			$this->errno = self::errServiceInvalid;
			$this->errmsg = "Service for URL[$url] is invalid now, errno[$errno] errmsg[$errmsg]";
		}
		elseif( $errno == 28/*CURLE_OPERATION_TIMEDOUT*/ )
		{
			$this->errno = self::errHttpTimeout;
			$this->errmsg = "Request for $url timeout: $errmsg";
		}
		elseif( $errno == CURLE_TOO_MANY_REDIRECTS ||
			$http_code == 301 || $http_code == 302 || $http_code == 307 )
		{
			//$errno == CURLE_OK can only indicate that the response is received, but it may
			//also be an error page or empty page, so we also need more checking when $errno == CURLE_OK
			$this->errno = self::errTooManyRedirects;
			$this->errmsg = "Request for $url caused too many redirections.";
		}
		elseif( $http_code >= 400 )
		{
			$this->errno = self::errResponseErrorPage;
			$this->errmsg = "Received HTTP error code $http_code while loading $url";
		}
		elseif( $this->body_len > $this->max_response_size )
		{
			$this->errno = self::errTooLargeResponse;
			$this->errmsg = "Response body for $url has at least {$this->body_len} bytes, " .
							"which has exceed the max response size[{$this->max_response_size}]";
		}
		elseif( $errno != CURLE_OK )
		{
			if( $this->body_len == 0 )
			{
				if( $http_code )
				{
					$this->errno = self::errNoResponseBody;
					$this->errmsg = "Request for $url returns HTTP code $http_code and no data.";
				}
				else
				{
					$this->errno = self::errNoResponse;
					$this->errmsg = "The URL $url has no response.";
				}
			}
			else
			{
				$this->errno = self::errOtherEror;
				$this->errmsg = "Request for $url failed, errno[$errno] errmsg[$errmsg]";
			}
		}
		else
		{
			$this->errno = self::SUCCESS;
			$this->errmsg = '';
			return true;
		}

		return false;
	}

	private function reset()
	{
		$this->errno = self::SUCCESS;
		$this->errmsg = '';
		$this->header = '';
		$this->body = '';
		$this->body_len = 0;
	}

    /*
		$url = 'www.baidu.com:8944/a.php?id=5',//必填,请求地址
		$cookie = '', //可选，cookie信息，可为数组或标准cookie串, 默认为 $_COOKIE['BDUSS']
		$data = '', //get请求时不填，post或put 数据，有值则说明是post/put请求,否则为get请求
		$header = array(
			'Content-Disposition'=>'attachment; filename=a.txt', 
			'Content-Type'=>'multipart/form-data'
		),
		$timeout = 3, //可选超时默认5秒
		$block, 是否用块流模式传输, 可设置块大小，及超时判断
    */
    public static function request($method = 'GET', $url, $cookie = '', $data = '', $header = array(), $timeout = 3, $block = TRUE) {
        $cookie_str = $return = '';
        $matches = parse_url($url);
        $host = $matches['host'];
        $path = isset($matches['path']) ? $matches['path'].(isset($matches['query']) ? '?'.$matches['query'] : '') : '/';
        $port = isset($matches['port']) ? $matches['port'] : 80;
        $host = $matches['host'].':'.$port;

        $cookie === '' && $cookie = $_COOKIE['BDUSS'];

        if( is_array($cookie) && count($cookie) > 0 ) {
            foreach( $cookie as $key => $value ) {
                $cookie_str .= "$key=$value; ";
            }
        } elseif(isset($cookie[10])) {
            $cookie_str = $cookie;
        }
        $method = strtoupper($method);

		$out = "$method $path HTTP/1.1\r\n";
		$out .= "User-Agent: curl/7.12.1 (x86_64-redhat-linux-gnu) libcurl/7.12.1 OpenSSL/0.9.7a zlib/1.2.1.2 libidn/0.5.6\r\n";
		$out .= "Host: $host\r\n";
		$out .= "Accept: */*\r\n";
		$out .= "Accept-Language: zh-cn\r\n";
		$out .= "Connection: Close\r\n";
        if($method !== 'GET') {
            // k1=v1&k2=v2&k3=v3
            $body = '';
            if( is_array($data) && count($data) > 0 ) {
                $delimiter = '';
                foreach( $data as $key => $value ) {
                    $body .= "$delimiter{$key}=$value";
                    $delimiter = '&';
                }
            } elseif(isset($data[10])) {
                $body = $data;
            }
            $out .= 'Content-Length: '.strlen($body)."\r\n";
            $out .= "Prama: no-cache\r\n";
            $out .= "Content-Type: application/x-www-form-urlencoded\r\n";
            $out .= "Connection: Close\r\n";
            if(count($header) > 0) {
                foreach($header as $k=>$v) {
                    $out .= $k.': '.$v."\r\n"; 
                }
            }
            $out .= "Cookie: $cookie_str\r\n\r\n";
            $out .= $body;
        } else {
			$out .= "Cookie: $cookie_str\r\n\r\n";
        }

        //Bd_Log::addNotice('o', $out);
        $return = '';
        $fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);
        if(!$fp) {
            return '';
        }
        stream_set_blocking($fp, $block);
        stream_set_timeout($fp, $timeout);
        fwrite($fp, $out);
        $res = stream_get_contents($fp);
        fclose($fp);
        $return = array();
        list($return['header'], $return['body'])= explode("\r\n\r\n", $res);
        $return['http_code'] = intval(substr($return['header'], 9, 3));
        return $return;
    }

}
