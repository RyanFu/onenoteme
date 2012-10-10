<div class="post-list">
    <?php foreach ((array)$models as $key => $model):?>
    <div class="panel panel20 post-item" data-id="<?php echo $model->id;?>">
    	<div class="post-author"><?php echo $model->authorName . '&nbsp;' . $model->createTime;?></div>
        <div class="item-detail">
            <div class="item-content"><?php echo $model->content;?></div>
            <?php if (($model->channel_id == CHANNEL_LENGTU || $model->channel_id == CHANNEL_GIRL) && $model->thumbnail):?>
            <div class="post-image">
                <div class="thumbnail">
                <?php if ($model->channel_id == CHANNEL_LENGTU): //只有冷图采用缩略图方式 ?>
                    <?php if ($model->imageIsLong):?>
                    <a href="<?php echo $model->bmiddlePic;?>" class="size-switcher" target="_blank" title="点击查看大图">
                        <?php echo CHtml::image($model->thumbnail, $model->title, array('class'=>'thumb'));?>
                        <img class="original hide" />
                    </a>
                    <?php else:?>
                    <?php echo CHtml::image($model->bmiddlePic, $model->title, array('class'=>'original'));?>
                    <?php endif;?>
                    <?php if ($model->imageIsLong):?>
                    <div class="thumb-pall"></div>
                    <?php endif;?>
                <?php elseif ($model->channel_id == CHANNEL_GIRL): //福利图直接显示 ?>
                    <a href="<?php echo $model->originalPic;?>" target="_blank" title="点击查看大图">
                        <?php echo CHtml::image($model->bmiddlePic, $model->title, array('class'=>'original'));?>
                    </a>
                <?php endif;?>
                </div>
                <?php if ($model->channel_id == CHANNEL_LENGTU && $model->imageIsLong):?>
                <div class="thumbnail-more">
                    <div class="lines">
                        <?php for ($i=0; $i<$model->lineCount; $i++):?>
                        <div class="line3"></div>
                        <?php endfor;?>
                        <div class="sjx"></div>
                    </div>
                </div>
                <?php endif;?>
            </div>
            <?php elseif ($model->channel_id == CHANNEL_VIDEO && $model->videoHtml):?>
            <div class="content-block video-player"><?php echo $model->videoHtml;?></div>
            <?php endif;?>
        </div>
        <?php if ($model->tags):?><div class="post-tags"><span class="cgray">标签：</span><?php echo $model->tagLinks;?></div><?php endif;?>
        <ul class="item-toolbar cgray">
        	<li class="upscore fleft"><a href="javascript:void(0);" class="site-bg"><?php echo $model->up_score;?></a></li>
        	<li class="downscore fleft"><a href="javascript:void(0);" class="site-bg">-<?php echo $model->down_score;?></a></li>
        	<li class="share fright"><a href="javascript:void(0);" class="site-bg">分享</a></li>
        	<li class="comment fright"><a href="javascript:void(0);" class="site-bg"><?php echo $model->comment_nums;?></a></li>
        	<div class="clear"></div>
        </ul>
        <div class="comment-list comment-list-<?php echo $model->id;?> hide"></div>
    </div>
        <div class="site-bg item-shadow"></div>
    <?php endforeach;?>
</div>

<?php if ($pages->pageCount > 1):?>
<div class="panel panel-pages"><div class="pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div></div>
<?php endif;?>

<script type="text/javascript">
$(function(){
	$('.post-image').on('click', '.thumbnail-more, .thumbnail a.size-switcher', function(event){
	    event.preventDefault();
	    var itemDiv = $(this).parents('.post-item');
	    itemDiv.find('.post-image .thumbnail-more').toggle();
	    itemDiv.find('.post-image .thumbnail a .thumb').toggle();
	    itemDiv.find('.post-image .thumb-pall').toggle();
	    var originalUrl = itemDiv.find('.post-image .thumbnail a').attr('href');
	    itemDiv.find('.post-image .thumbnail a .original').attr('src', originalUrl).toggle();
	    var itemPos = itemDiv.position();
	    $('body').scrollTop(itemPos.top);
	});
});
</script>




