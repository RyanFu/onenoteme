<div class="post-list">
    <?php foreach ((array)$models as $key => $model):?>
    <div class="panel panel20 post-item">
    	<div class="post-author"><?php echo $model->authorName . '&nbsp;' . $model->createTime;?></div>
        <div class="item-detail">
            <a class="item-link" href="<?php echo aurl('post/show', array('id'=>$model->id));?>" target="_blank" title="新窗口中查看段子">: :</a>
            <span class="item-content">
                <?php echo $model->content;?>
            </span>
            <?php if ($model->bmiddlePic):?>
            <div class="post-image">
                <div class="thumbnail">
                    <a href="<?php echo $model->bmiddlePic;?>" target="_blank">
                    <?php echo CHtml::image($model->thumbnail, $model->title, array('class'=>'thumb'));?>
                    <img class="original hide" />
                    </a>
                </div>
                <div class="thumbnail-more">
                    <div class="thumb-pall"></div>
                    <div class="lines">
                        <div class="line3"></div>
                        <div class="line3"></div>
                        <div class="line3"></div>
                        <div class="line3"></div>
                        <div class="sjx"></div>
                    </div>
                </div>
            </div>
            <?php endif;?>
        </div>
        <?php if ($model->tags):?><div class="post-tags"><span class="cgray">标签：</span><?php echo $model->tagLinks;?></div><?php endif;?>
        <ul class="item-toolbar cgray" postid="<?php echo $model->id;?>">
        	<li class="upscore fleft" pid="<?php echo $model->id;?>"><?php echo $model->up_score;?></li>
        	<li class="downscore fleft" pid="<?php echo $model->id;?>"><?php echo $model->down_score;?></li>
        	<li class="fright"><span class="sns-share qzone"></span></li>
        	<li class="fright"><span class="sns-share qqt"></span></li>
        	<li class="fright"><span class="sns-share weibo"></span></li>
        	<li class="comment-nums fright">
        	    <a href="javascript:void(0);" url="<?php echo aurl('comment/list', array('pid'=>$model->id));?>" title="查看评论" class="view-comments" pid="<?php echo $model->id;?>"><?php echo $model->comment_nums;?>条评论</a>
        	    <a href="<?php echo aurl('post/show', array('id'=>$model->id), '', 'comment-list');?>" title="新窗口中查看查看评论" target="_blank">: :</a>
        	</li>
        	<div class="clear"></div>
        </ul>
        <div class="comment-list comment-list-<?php echo $model->id;?> hide"></div>
    </div>
    <?php endforeach;?>
</div>

<?php if ($pages->pageCount > 1):?>
<div class="panel panel10"><div class="pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div></div>
<?php endif;?>

<span id="jqvar" scoreurl="<?php echo aurl('post/score');?>" class="hide"></span>

<script type="text/javascript">
$(function(){
	$('.post-image').on('click', '.thumbnail-more, .thumbnail a', function(event){
	    event.preventDefault();
	    var itemDiv = $(this).parents('.post-item');
	    itemDiv.find('.post-image .thumbnail-more').toggle();
	    itemDiv.find('.post-image .thumbnail a .thumb').toggle();
	    var originalUrl = itemDiv.find('.post-image .thumbnail a').attr('href');
	    itemDiv.find('.post-image .thumbnail a .original').attr('src', originalUrl).toggle();
	    var itemPos = itemDiv.position();
	    $('body').scrollTop(itemPos.top);
	});
});
</script>




