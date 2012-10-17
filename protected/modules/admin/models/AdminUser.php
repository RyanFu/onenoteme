<?php
/**
 * @author chendong
 *
 * @property string $infoUrl
 * @property string $editurl
 * @property string $verifyUrl
 * @property string $stateText;
 */
class AdminUser extends User
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminUser the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public static function stateLabels()
    {
        return array(
            USER_STATE_ENABLED => t('user_enabled', 'admin'),
            USER_STATE_FORBIDDEN => t('user_forbidden', 'admin'),
            USER_STATE_UNVERIFY => t('user_unverify', 'admin'),
        );
    }
    
    public function getInfoUrl()
    {
        return url('admin/user/info', array('id'=>$this->id));
    }
    
    public function getEditUrl()
    {
        return l(t('edit', 'admin'), url('admin/user/create', array('id'=>$this->id)));
    }
    
    public function getVerifyUrl()
    {
        $text = t(($this->state == USER_STATE_UNVERIFY) ? 'user_enabled' : 'user_disabled', 'admin');
        return l($text, url('admin/user/setVerify', array('id'=>$this->id)), array('class'=>'set-verify'));
    }
    
    public function getResetPasswordUrl()
    {
        return l(t('reset_password', 'admin'), url('admin/user/resetPassword', array('id'=>$this->id)));
    }
    
    public function getStateText()
    {
        if ($this->state == USER_STATE_ENABLED)
            $html = '<span class="label label-success">' . t('user_enabled', 'admin') . '</span>';
	    elseif ($this->state == USER_STATE_FORBIDDEN)
	        $html = '<span class="label label-important">' . t('user_forbidden', 'admin') . '</span>';
	    elseif ($this->state == USER_STATE_UNVERIFY)
    	    $html = '<span class="label label-warning">' . t('user_unverify', 'admin') . '</span>';
	    else
	        $html = '<span class="label">Unkown</span>';
	    
	    return $html;
    }
    
    public function getStateAjaxLink()
    {
        $url = url('admin/user/setVerify', array('id'=>$this->id));
        
        if ($this->state == USER_STATE_ENABLED)
            $html = '<a class="row-state label label-success" href="%s">' . t('user_enabled', 'admin') . '</a>';
        elseif ($this->state == USER_STATE_FORBIDDEN)
            $html = '<a class="row-state label label-important" href="%s">' . t('user_forbidden', 'admin') . '</a>';
        elseif ($this->state == USER_STATE_UNVERIFY)
            $html = '<a class="row-state label label-warning" href="%s">' . t('user_unverify', 'admin') . '</a>';
        else
            $html = '<a class="label" href="javascript:void(0);">Unkown</a>';
        
        return sprintf($html, $url);
    }
    
    public static function fetchList($criteria = null, $sort = true, $pages = true)
    {
        $criteria = ($criteria === null) ? new CDbCriteria() : $criteria;
        if ($criteria->limit <= 0)
            $criteria->limit = param('adminUserCountOfPage');
         
        if ($sort) {
            $sort  = new CSort(__CLASS__);
            $sort->defaultOrder = 't.id desc';
            $sort->applyOrder($criteria);
        }
         
        if ($pages) {
            $count = self::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->setPageSize($criteria->limit);
            $pages->applyLimit($criteria);
        }
         
        $models = self::model()->findAll($criteria);
         
        $data = array(
            'models' => $models,
            'sort' => $sort,
            'pages' => $pages,
        );
         
        return $data;
    }
    
}