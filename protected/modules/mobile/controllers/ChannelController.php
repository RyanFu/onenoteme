<?php

class CategoryController extends MobileController
{
	public function actionPosts($id)
	{
	    $id = (int)$id;
	    $data = self::fetchLatestPosts($id);
	    
	    $this->setSiteTitle('');
	    cs()->registerMetaTag('all', 'robots');
	    $this->render('/post/list', $data);
	}

	private static function fetchLatestPosts($id)
	{
	    $id = (int)$id;
	    $criteria = new CDbCriteria();
	    $criteria->order = 't.istop desc, t.create_time desc';
	    $criteria->limit = param('postCountOfPage');
	    $criteria->scopes = array('published');
	    $criteria->addColumnCondition(array('category_id' => $id));
	
	    $count = MobilePost::model()->count($criteria);
	    $pages = new CPagination($count);
	    $pages->setPageSize(param('mobile_post_list_page_count'));
	    $pages->applyLimit($criteria);
	    $posts = MobilePost::model()->findAll($criteria);
	
	    return array(
	        'models' => $posts,
	        'pages' => $pages,
	    );
	}
}