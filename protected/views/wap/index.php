<div class="post-list">
    <?php foreach ((array)$models as $index => $model):?>
    <div class="post-item">
    	<div class="post-user"><?php echo $model->authorName . '&nbsp;' . $model->createTime;?></div>
        <div class="post-content">
            <?php echo $model->content;?>
            <?php if ($model->bmiddlePic) echo '<br />' . CHtml::image($model->bmiddlePic, $model->title, array('class'=>'item-pic'));?>
        </div>
        <?php if ($model->tags):?><div class="post-tags"><span class="cgray">标签：</span><?php echo $model->getTagLinks('wap/tag', '&nbsp;', '_self');?></div><?php endif;?>
    </div>
    <?php if ($index == 1):?>
    <div class="admob">
        <script type="text/javascript">
            netease_union_user_id = 6156606;
            netease_union_site_id = 25143;
            netease_union_worktype = 15;
            netease_union_promote_type = 3;
            netease_union_width = 300;
            netease_union_height = 120;
            netease_union_link_id = 659;
        </script>
        <script type="text/javascript" src="http://union.netease.com/sys_js/display.js"></script>
    </div>
    <?php endif;?>
    <?php endforeach;?>
</div>

<?php if ($pages->pageCount > 1):?>
<div class="pages"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'skin'=>'wap'));?></div>
<?php endif;?>