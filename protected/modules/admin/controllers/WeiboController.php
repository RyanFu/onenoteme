<?php
class WeiboController extends AdminController
{
    public function actionSinat()
    {
        $callback = aurl('admin/weibo/sinacb');
        $url = sprintf('https://api.weibo.com/oauth2/authorize?client_id=%s&response_type=code&redirect_uri=%s', WEIBO_APP_KEY, $callback);
        $this->redirect($url);
        exit(0);
    }
    
    public function actionSinacb($code)
    {
        $code = strip_tags(trim($code));
        $callback = aurl('admin/weibo/sinacb');
        $url = sprintf('https://api.weibo.com/oauth2/access_token?grant_type=authorization_code&redirect_uri=%s&code=%s', $callback, $code);
        $curl = new CdCurl();
        $curl->basic_auth(WEIBO_APP_KEY, WEIBO_APP_SECRET);
        $curl->post($url);
        if ($curl->errno() != 0)
            throw new CException(503, '获取access_token出错');
        else {
            $data = json_decode($curl->rawdata(), true);
            if (empty($data))
                throw new CException('获取access_token错误');
        
            $cacheTokenKey = 'sina_weibo_access_token';
            $result1 = app()->cache->set($cacheTokenKey, $data['access_token'], $expires_in);
            $cacheUserIDKey = 'sina_weibo_user_id';
            $result2 = app()->cache->set($cacheUserIDKey, $data['uid'], $expires_in);
            echo $result1 && $result2 ? '授权登录成功' : '授权登录失败';
        }
    }
    
    public function actionQqt()
    {
        $callback = aurl('admin/weibo/qqtcb');
        $url = sprintf('https://open.t.qq.com/cgi-bin/oauth2/authorize?client_id=%s&response_type=code&redirect_uri=%s', QQT_APP_KEY, $callback);
        $this->redirect($url);
        exit(0);
    }
    
    public function actionQqtcb($code, $openid)
    {
        $code = strip_tags(trim($code));
        $callback = aurl('admin/weibo/qqtcb');
        $url = sprintf('https://open.t.qq.com/cgi-bin/oauth2/access_token?client_id=%s&client_secret=%s&grant_type=authorization_code&redirect_uri=%s&code=%s', QQT_APP_KEY, QQT_APP_SECRET, $callback, $code);
        $curl = new CdCurl();
        $curl->post($url);
        if ($curl->errno() != 0)
            throw new CHttpException(503, '获取token出错');
        else {
            $returnString = $curl->rawdata();
            if (empty($returnString))
                throw new CException('获取access_token错误');
        
            /*
             * $access_token
             * $expires_in
             * $refresh_token
            */
            parse_str($returnString);
        
            $cacheTokenKey = 'qq_weibo_access_token';
            $result1 = app()->cache->set($cacheTokenKey, $access_token, $expires_in);
            $cacheUserIDKey = 'qq_weibo_user_id';
            $result2 = app()->cache->set($cacheUserIDKey, $openid, $expires_in);
            echo $result1 && $result2 ? '授权登录成功' : '授权登录失败';
        }
    }
    
    public function actionNetease()
    {
        
    }
    
    public function actionTest()
    {

        echo app()->cache->get('sina_weibo_user_id') . '<br />';
        echo app()->cache->get('sina_weibo_access_token') . '<br />';
        echo app()->cache->get('qq_weibo_user_id') . '<br />';
        echo app()->cache->get('qq_weibo_access_token') . '<br />';
    }
    
    
    public function actionPosts()
    {
        $pageSize = 1;
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('channel_id'=>CHANNEL_DUANZI, 'weibo_id' => ''));
        $criteria->limit = $pageSize;
        $criteria->order = 't.id asc';
        $models[] = AdminPost::model()->find($criteria);
        
        $pageSize = 1;
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('channel_id'=>CHANNEL_LENGTU, 'weibo_id' => ''));
        $criteria->limit = $pageSize;
        $criteria->order = 't.id asc';
        $models[] = AdminPost::model()->find($criteria);
        
        $pageSize = 1;
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('channel_id'=>CHANNEL_GIRL, 'weibo_id' => ''));
        $criteria->limit = $pageSize;
        $criteria->order = 't.id asc';
        $models[] = AdminPost::model()->find($criteria);
        
        $data = array(
            'models' => $models,
        );
        $this->render('posts', $data);
    }
    
    public function actionSkip($id)
    {
        $result = AdminPost::model()->updateByPk($id, array('weibo_id'=>'0'));
        echo (int)$result;
        exit(0);
    }
    
    public function actionCreate($id)
    {
        $id = (int)$id;
        $model = AdminPost::model()->findByPk($id);
        if ($model === null) {
            echo 0;
            exit(0);
        }
        
        $picUrl = $model->getBmiddlePic();
        if (empty($picUrl)) {
            $result = self::SinatUpdate($model);
            $result2 = self::qqtUpdate($model);
        }
        else {
            $result = self::sinatUpload($model);
            $result2 = self::qqtUpload($model);
        }
        
        if ($result !== false) {
            $model->weibo_id = $result;
            $model->save(true, array('weibo_id'));
        }
        
        echo ($result === false) ? 0 : $result;
        exit(0);
    }
    
    private static function SinatUpdate(AdminPost $model)
    {
        if (empty($model->content)) return false;
        
        $url = 'https://upload.api.weibo.com/2/statuses/update.json';
        
        
        $sinatShortUrl = self::sinatShortUrl($model->getUrl());
        $urlLen = empty($sinatShortUrl) ? 0 : strlen($sinatShortUrl);
        $content = mb_substr($model->content, 0, 130 - $urlLen, app()->charset) . '...' . $sinatShortUrl . ' @挖段子网';
        $data = array(
            'source' => WEIBO_APP_KEY,
            'access_token' => app()->cache->get('sina_weibo_access_token'),
            'status' => $content,
        );
        foreach ($data as $key => $item)
            $args[] = urlencode($key) . '=' . $item;
        
        $curl = new CdCurl();
        $curl->post($url, join('&', $args));
//         var_dump($curl->rawdata());
//         var_dump($curl->errno());exit;
        if ($curl->errno() == 0) {
            $result = json_decode($curl->rawdata(), true);
            return $result['idstr'] ? $result['idstr'] : false;
        }
        else
            return false;
    }
    
    private static function sinatUpload(AdminPost $model)
    {
        if (empty($model->content)) return false;
        
        $curl = new CdCurl();
        $curl->get($model->getBmiddlePic());
        if ($curl->errno() == 0) {
            $picData = $curl->rawdata();
            $picfile = app()->getRuntimePath() . DS . uniqid();
            $result = file_put_contents($picfile, $picData);
            if ($result === false)
                throw new CException('生成临时文件出错', 0);
        }
        else
            return false;
        
        $url = 'https://upload.api.weibo.com/2/statuses/upload.json';
        
        $sinatShortUrl = self::sinatShortUrl($model->getUrl());
        $urlLen = empty($sinatShortUrl) ? 0 : strlen($sinatShortUrl);
        $content = mb_substr($model->content, 0, 130 - $urlLen, app()->charset) . '...' . $sinatShortUrl . ' @挖段子网';
        $data = array(
            'source' => WEIBO_APP_KEY,
            'access_token' => app()->cache->get('sina_weibo_access_token'),
            'status' => $content,
            'pic' => '@' . $picfile,
        );
        
        $curl = new CdCurl();
        $curl->post($url, $data);
        @unlink($picfile);
        if ($curl->errno() == 0) {
            $result = json_decode($curl->rawdata(), true);
            return $result['idstr'] ? $result['idstr'] : false;
        }
        else
            return false;
    }
    
    private static function sinatShortUrl($longUrl)
    {
        $url = 'https://api.weibo.com/2/short_url/shorten.json';
        $data = array(
            'source' => WEIBO_APP_KEY,
            'url_long' => $longUrl,
        );
        
        $curl = new CdCurl();
        $curl->get($url, $data);
        if ($curl->errno() == 0) {
            $result = json_decode($curl->rawdata(), true);
            $short = $result['urls'][0];
            return ($short['result']) ? $short['url_short'] : false;
        }
        else
            return false;
    }
    
    private static function qqtUpdate(AdminPost $model)
    {
        if (empty($model->content)) return false;
        
        $url = 'https://open.t.qq.com/api/t/add';
        
        $sinatShortUrl = self::sinatShortUrl($model->getUrl());
        $urlLen = empty($sinatShortUrl) ? 0 : strlen($sinatShortUrl);
        $content = mb_substr($model->content, 0, 130 - $urlLen, app()->charset) . '...' . $sinatShortUrl . ' @挖段子网';
        $data = array(
            'oauth_consumer_key' => QQT_APP_KEY,
            'access_token' => app()->cache->get('qq_weibo_access_token'),
            'openid' => self::$_userID,
            'clientip' => request()->getUserHostAddress(),
            'oauth_version' => '2.a',
            'scope' => 'all',
            'format' => 'json',
            'content' => $content,
            'syncflag' => 0,
        );
        foreach ($data as $key => $item)
            $args[] = urlencode($key) . '=' . $item;
        
        $curl = new CdCurl();
        $curl->post($url, join('&', $args));
        //         var_dump($curl->rawdata());
        //         var_dump($curl->errno());exit;
        if ($curl->errno() == 0) {
            $data = json_decode($curl->rawdata(), true);
            return ($data['ret'] == 0) ? $data['data']['id'] : false;
        }
        else
            return false;
        
    }
    
    private static function qqtUpload(AdminPost $model)
    {
        if (empty($model->content)) return false;
        
        $curl = new CdCurl();
        $curl->get($model->getBmiddlePic());
        if ($curl->errno() == 0) {
            $picData = $curl->rawdata();
            $picfile = app()->getRuntimePath() . DS . uniqid();
            $result = file_put_contents($picfile, $picData);
            if ($result === false)
                throw new CException('生成临时文件出错', 0);
        }
        else
            return false;
        
        $url = 'https://open.t.qq.com/api/t/add_pic';
        
        $sinatShortUrl = self::sinatShortUrl($model->getUrl());
        $urlLen = empty($sinatShortUrl) ? 0 : strlen($sinatShortUrl);
        $content = mb_substr($model->content, 0, 130 - $urlLen, app()->charset) . '...' . $sinatShortUrl . ' @挖段子网';
        $data = array(
            'oauth_consumer_key' => QQT_APP_KEY,
            'access_token' => app()->cache->get('qq_weibo_access_token'),
            'openid' => self::$_userID,
            'clientip' => request()->getUserHostAddress(),
            'oauth_version' => '2.a',
            'scope' => 'all',
            'format' => 'json',
            'content' => $content,
            'syncflag' => 0,
            'pic' => '@' . $picfile,
        );
        foreach ($data as $key => $item)
            $args[] = urlencode($key) . '=' . $item;
        
        $curl = new CdCurl();
        $curl->post($url, join('&', $args));
        //         var_dump($curl->rawdata());
        //         var_dump($curl->errno());exit;
        if ($curl->errno() == 0) {
            $data = json_decode($curl->rawdata(), true);
            return ($data['ret'] == 0) ? $data['data']['id'] : false;
        }
        else
            return false;
    }
}

