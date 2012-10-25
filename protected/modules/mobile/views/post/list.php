<?php foreach ($models as $model):?>
<dl class="post-item clearfix">
    <dt class="beta-title clearfix">
        <h1 class="post-title"><?php echo $model->titleLink;?></h1>
        <span class="comment-number"><?php echo l($model->comment_nums, $model->url, array('title'=>$model->title));?></span>
    </dt>
    <dd class="summary clearfix">
        <?php echo $model->filterSummary;?>
    </dd>
    <dd class="post-extra"><?php echo $model->authorName;?>&nbsp;|&nbsp;<?php echo $model->createTime;?></dd>
    <dd class="read-more clearfix">
        <a href="<?php echo $model->url;?>">
            <span><?php echo t('read_full_text', 'mobile');?></span>
            <span class="pull-right">&gt;</span>
        </a>
    </dd>
</dl>
<?php endforeach;?>

<?php if ($pages->pageCount > 1):?>
<div class="pagination pagination-centered"><?php $this->widget('CLinkPager', array('pages'=>$pages, 'skin'=>'mobile'));?></div>
<?php endif;?>