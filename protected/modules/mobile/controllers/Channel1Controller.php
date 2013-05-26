<?php

class Channel1Controller extends MobileController
{
    public function filters()
    {
        return array(
            array(
                'COutputCache + joke, lengtu, girl, video, ghost, hot, latest, day, week, month',
                'duration' => param('mobile_post_list_cache_expire'),
                'varyByParam' => array('page'),
                'varyByExpression' => array(request(), 'getServerName'),
            ),
        );
    }

    public function actionLatest($page = 1)
    {
        $this->channel = 'latest';
        $this->setSiteTitle('');
        $this->setKeywords(p('home_index_keywords'));
        $this->setDescription(p('home_index_description'));
    
        $criteria = new CDbCriteria();
        $criteria->scopes = array('homeshow', 'published');
        $criteria->addColumnCondition(array('channel_id' => CHANNEL_FUNNY));
        $criteria->addInCondition('t.media_type', array(MEDIA_TYPE_TEXT, MEDIA_TYPE_IMAGE));
        $criteria->order = 't.istop desc, t.create_time desc';
        $criteria->limit = (int)p('line_post_count_page');
    
        $data = self::fetchPosts($criteria);
        $this->render('posts', $data);
    }
    

    public function actionHot($page = 1)
    {
        $this->setSiteTitle('12小时内人最热门笑话');
    
        $this->fetchFunnyHotPosts(8);
    }
    
    public function actionDay($page = 1)
    {
        $this->setSiteTitle('24小时内人最热门笑话');
    
        $this->fetchFunnyHotPosts(24);
    }
    
    public function actionWeek($page = 1)
    {
        $this->setSiteTitle('一周内人最热门笑话');
    
        $this->fetchFunnyHotPosts(7*24);
    }
    
    public function actionMonth($page = 1)
    {
        $this->setSiteTitle('一月内人最热门笑话');
    
        $this->fetchFunnyHotPosts(30*24);
    }
    
    
	public function actionJoke($page = 1)
	{
	    $count = (int)p('mobile_post_list_page_count');
	    $data = self::fetchFunnyMediaPosts(MEDIA_TYPE_TEXT, $count);
	     
	    $this->pageTitle = '挖笑话 - 最冷笑话精选，每天分享笑话N枚，你的贴身开心果';
        $this->setDescription($this->pageTitle);
        $this->setKeywords('挖笑话,糗事,内涵笑话,爆笑笑话,幽默笑话,笑话大全,爆笑短信,xiaohua,冷笑话,短信笑话,小笑话,笑话短信,经典笑话,冷笑话大全,短笑话,搞笑短信,笑话大全乐翻天,搞笑笑话,疯狂恶搞,爆笑童趣,雷人囧事');
        
        $this->channel = CHANNEL_FUNNY . MEDIA_TYPE_TEXT;
	    cs()->registerMetaTag('all', 'robots');
	    $this->render('posts', $data);
	}

	public function actionLengtu($page = 1)
	{
	    $count = (int)p('mobile_post_list_page_count');
	    $data = self::fetchFunnyMediaPosts(MEDIA_TYPE_IMAGE, $count);
	     
	    $this->pageTitle = '挖趣图 - 最搞笑的，最好玩的，最内涵的图片精选';
        $this->setDescription($this->pageTitle);
        $this->setKeywords('挖趣图,搞笑图片,内涵图,邪恶图片,色色图,暴走漫画,微漫画,4格漫画,8格漫画,搞笑漫画,内涵漫画,邪恶漫画,疯狂恶搞,爆笑童趣,雷人囧事,动画萌图,狗狗萌图,猫咪萌图,喵星人萌图,汪星人萌图');
        
        $this->channel = CHANNEL_FUNNY . MEDIA_TYPE_IMAGE;
	    cs()->registerMetaTag('all', 'robots');
	    $this->render('posts', $data);
	}
	
	public function actionVideo($page = 1)
	{
	    $count = (int)p('mobile_post_list_page_count');
	    $data = self::fetchFunnyMediaPosts(MEDIA_TYPE_VIDEO, $count);
	     
	    $this->pageTitle = '挖短片 - 各种有趣的，新奇的，经典的，有意思的精品视频短片';
        $this->setDescription($this->pageTitle);
        $this->setKeywords('搞笑视频短片,cf搞笑视频,lol搞笑视频,搞笑视频,疯狂恶搞,爆笑童趣,雷人囧事,动物奇趣,优酷搞笑视频,娱乐搞笑视频,土豆搞笑视频,激动搞笑视频');
        
        $this->channel = CHANNEL_FUNNY . MEDIA_TYPE_VIDEO;
	    cs()->registerMetaTag('all', 'robots');
	    $this->render('posts', $data);
	}


	private function fetchFunnyHotPosts($hours)
	{
	    $this->channel = 'hot';
	    $this->setKeywords(p('home_index_keywords'));
	    $this->setDescription(p('home_index_description'));
	
	    $criteria = new CDbCriteria();
	    $criteria->scopes = array('homeshow', 'published');
	    $criteria->addColumnCondition(array('channel_id' => CHANNEL_FUNNY));
	    $criteria->addInCondition('t.media_type', array(MEDIA_TYPE_TEXT, MEDIA_TYPE_IMAGE));
	    if ($hours > 0) {
	        $fromtime = $_SERVER['REQUEST_TIME'] - $hours * 3600;
	        $criteria->addCondition('t.create_time > :fromtime');
	        $criteria->params[':fromtime'] = $fromtime;
	    }
	    $criteria->order = 't.istop desc, (t.up_score-t.down_score) desc, t.create_time desc';
	    $limit = (int)p('mobile_post_list_page_count');
	    $criteria->limit = $limit;
	
	    $data = self::fetchPosts($criteria);
	    $this->render('posts', $data);
	}
	
	
	private function fetchFunnyMediaPosts($typeid, $limit, $with = null)
	{
	    $this->channel = CHANNEL_FUNNY . $typeid;
	
	    $criteria = new CDbCriteria();
	    $criteria->scopes = array('published');
	    $criteria->addColumnCondition(array('channel_id' => CHANNEL_FUNNY, 'media_type'=>(int)$typeid));
	    $criteria->order = 't.istop desc, t.create_time desc';
	    $criteria->limit = (int)$limit;
	    if (!empty($with))
	        $criteria->with = $with;
	
	    return self::fetchPosts($criteria);
	}
	
	private static function fetchPosts(CDbCriteria $criteria)
	{
	    $duration = 60*60*24;
	    $count = MobilePost::model()->count($criteria);
	    var_dump($criteria->toArray());
	    echo '<hr />';var_dump($count);echo '<hr />';
	    $pages = new CPagination($count);
	    $pages->setPageSize($criteria->limit);
	    $pages->applyLimit($criteria);

	    $models = MobilePost::model()->findAll($criteria);
	
	    echo $pages->pageSize.'<br />';
	    echo $pages->pageCount.'<br />';
	    exit;
	    return array(
            'models' => $models,
            'pages' => $pages,
	    );
	}
	
	public function actionGhost($page = 1)
	{
	    $this->redirect(CDBaseUrl::mobileHomeUrl(), true, 301);
	}
	
	public function actionGirl($page = 1)
	{
	    $this->redirect(CDBaseUrl::mobileHomeUrl(), true, 301);
	}
}



