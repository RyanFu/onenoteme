<?php
/**
 * AdminAdvert
 * @author chendong
 * @property string $editUrl
 * @property string $editLink
 * @property string $stateLink
 * @property string $deleteLink
 * @property string $nameLink
 */
class AdminAdvert extends Advert
{
    /**
     * Returns the static model of the specified AR class.
     * @return AdminAdvert the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getEditUrl()
    {
        return url('admin/advert/create', array('id'=>$this->id));
    }
    
    public function getEditLink()
    {
        return l(t('edit', 'admin'), $this->getEditUrl());
    }
    
    public function getNameLink()
    {
        return l($this->name, url('admin/adcode/list', array('adid'=>$this->id)));
    }
    
    public function getStateLink()
    {
        $text = t($this->state == ADVERT_STATE_ENABLED ? 'advert_enabled' : 'advert_disabled', 'admin');
        $class = $this->state == ADVERT_STATE_ENABLED ? 'row-state label label-success' : 'row-state label label-important';
        return l($text, url('admin/advert/setstate', array('id'=>$this->id)), array('class'=>$class));
    }
    
    public function getDeleteLink()
    {
        return l(t('delete', 'admin'), url('admin/advert/setdelete', array('id'=>$this->id)), array('class'=>'set-delete'));
    }
    
}