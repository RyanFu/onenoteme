<?php
class RestPost extends Post
{
    /**
     * Returns the static model of the specified AR class.
     * @return RestPost the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array_merge(parent::relations(), array(
            'user' => array(self::BELONGS_TO, 'RestUser', 'user_id',
    		        'select' => array('id', 'username', 'screen_name', 'create_time', 'create_ip', 'state', 'token', 'token_time', 'source')),
            'comments' => array(self::HAS_MANY, 'RestComment', 'post_id', 'limit'=>10),
        ));
    }
    
    public function getApiCreateTime()
    {
        $format = 'd日 H:i';
        return parent::getCreateTime($format);
    }
    
    public function getApiTitle()
    {
        return trim(strip_tags($this->title));
    }
    
    public function getApiContent()
    {
        $content = strip_tags($this->content);
        $content = str_replace('&nbsp;', '', $content);
        $lines = explode("\n", $content);
        $lines = array_map('trim', $lines);
        $lines = array_filter($lines);
        $content = join("\n", $lines);
        return $content;
    }
    
    public function getApiContentHtml()
    {
        $html = '<!doctype html><html><head><meta charset="utf-8" /><title>' . $this->title . '</title></head><body>';
        $html .= strip_tags($this->content, '<p><b><strong><span><img>');
        $html .= '</body></html>';
        
        return $html;
    }
}