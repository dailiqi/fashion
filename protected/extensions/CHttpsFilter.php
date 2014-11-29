<?php
class CHttpsFilter extends CFilter {
    protected function preFilter( $filterChain ) {
        if ( $_SERVER['SERVER_PORT'] != 443 ) {
            # Redirect to the secure version of the page.
            if(YII_DEBUG) {
                return true;
                $url = 'https://' . $_SERVER['HTTP_HOST'].
                    Yii::app()->getRequest()->requestUri;
            } else {
                $url = 'https://www.' .
                    Yii::app()->getRequest()->serverName .
                    Yii::app()->getRequest()->requestUri;    
            }
            Yii::app()->request->redirect($url);
            return false;
        }
        return true;
    }
}