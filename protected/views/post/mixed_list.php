<div class="panel panel15 bottom10px">
    <div class="fleft apps-list">
        <a href="http://itunes.apple.com/cn/app//id486268988?mt=8" target="_blank">下载iPhone应用2.2.1版</a>
        <a href="http://s.waduanzi.com/android/waduanzi.apk" target="_blank">下载Android应用1.1.0版</a>
        <a href="http://www.weibo.com/cdcchen" target="_blank">@新浪微博</a>
        <a href="http://t.qq.com/cdcchen" target="_blank">@腾讯微博</a>
        <span>QQ群：49401589</span>
    </div>
    <ul class="mode-switch fright">
        <li class="fall on"><a href="<?php echo aurl($this->route, array('page'=>(int)$_GET['page'], 's'=>POST_LIST_STYLE_WATERFALL));?>">缩略图</a></li>
        <li class="list"><a href="<?php echo aurl($this->route, array('page'=>(int)$_GET['page']));?>">列表</a></li>
    </ul>
    <div class="clear"></div>
</div>

<?php if ($fallTitle):?><h2 class="cd-caption">与标签“<?php echo $fallTitle;?>”相关的内容</h2><?php endif;?>
<div id="waterfall-container">
    <?php foreach ((array)$models as $index => $model):?>
    <div class="waterfall-item">
        <div class="post-time"><?php echo $model->createTime;?></div>
        <?php if ($model->thumbnail):?><div class="pic-block"><?php echo $model->thumbnailLink;?></div><?php endif;?>
        <p><?php echo l($model->content, $model->url, array('target'=>'_blank'));?></p>
    </div>
    <?php endforeach;?>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php if($pages->pageCount > 1):?>
<div id="page-nav" class="cd-pages"><?php $this->widget('CLinkPager', array('pages'=>$pages));?></div>
<?php endif;?>
<div id="manual-load" class="radius5px hide">查看更多</div>

<script type="text/javascript">
$(function(){
	Waduanzi.AjustImgWidth($('.pic-block img'), 197);
	
    var container = $('#waterfall-container');
    container.imagesLoaded(function(){
    	container.masonry({
            itemSelector: '.waterfall-item'
        });
        var count = 1;
        container.infinitescroll({
        	navSelector: '#page-nav',
        	nextSelector: '#page-nav .next a',
        	itemSelector: '.waterfall-item',
        	dataType: 'html',
        	infid: 0,
        	loading: {
        		finishedMsg: '已经载入全部内容。',
        		msgText: '正在载入更多内容。。。',
        		img: '<?php echo sbu('images/loading.gif');?>'
        	}
        },
        function(newElements) {
            var newElems = $(newElements).css({opacity:0});
            //newElems.imagesLoaded(function(){
                newElems.animate({opacity:1});
                container.masonry('appended', newElems, true);

                if (count >= 2) {
                	$(window).unbind('.infscr');
                	$(document).on('click', '#manual-load', function(event){
                        container.infinitescroll('retrieve');
                        return false;
              	    });
                	$('#manual-load').show();
                    count = 1;
                }
                else
                    count++;
            //});
        });
    });
    $(document).ajaxError(function(event, xhr, opt) {
    	if (xhr.status == 404) $('div.pages').remove();
	});
	
    $('#waterfall-container').on('hover', '.waterfall-item', function(event){
        $(this).toggleClass('item-bg');
    });
});
</script>

<?php cs()->registerScriptFile(sbu('libs/jquery.masonry.min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(sbu('libs/jquery.infinitescroll.min.js'), CClientScript::POS_END);?>

