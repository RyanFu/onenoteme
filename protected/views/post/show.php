<script type="text/javascript">
<!--
_hmt && _hmt.push(['_setCustomVar', 2, 'channel_id', <?php echo (int)$this->channel;?>, 3]);
//-->
</script>
<div class="fleft cd-container detail-container">
	<div class="panel panel20 post-detail post-box">
		<div class="content-block post-content">
		    <div class="post-author">
        	    <?php echo $post->getAuthorAvatar();?>
            	<?php echo $post->getAuthorNameLink();?>
        	</div>
		    <div class="item-title">
		        <?php if (!$post->isTextType || $post->hasTitle):?>
                    <h1><?php echo h($post->title);?></h1>
                <?php endif;?>
            </div>
		    <?php if ($post->tags):?><div class="post-tags">标签：<?php echo $post->tagLinks;?></div><?php endif;?>
        </div>
        <?php if ($post->getIsVideoType() && $post->videoHtml):?>
        <div class="content-block video-player"><?php echo $post->videoHtml;?></div>
		<?php endif;?>
        <div class="item-content"><?php echo $post->filterContent;?></div>
        
        <div class="change-post clearfix">
            <?php if ($prevUrl):?>
            <a class="site-bg prev" href="<?php echo $prevUrl;?>"></a>
            <?php endif;?>
            <?php if ($nextUrl):?>
            <a class="site-bg next" href="<?php echo $nextUrl;?>"></a>
            <?php endif;?>
            <div class="clear"></div>
        </div>
        
        <div class="item-toolbar">
            <ul>
            	<li class="fleft"><a rel="nofollow" href="javascript:void(0);" class="upscore site-bg" data-id="<?php echo $post->id;?>" data-score="1" data-url="<?php echo aurl('post/score');?>"><?php echo $post->up_score;?></a></li>
            	<li class="fleft"><a rel="nofollow" href="javascript:void(0);" class="downscore site-bg" data-id="<?php echo $post->id;?>" data-score="-1" data-url="<?php echo aurl('post/score');?>"><?php echo $post->downScore;?></a></li>
            	<li class="fright"><a rel="nofollow" href="javascript:void(0);" class="share site-bg">分享</a></li>
            	<li class="fright"><a rel="nofollow" href="javascript:void(0);" class="favorite site-bg" data-id="<?php echo $post->id;?>" data-url="<?php echo $post->likeUrl;?>"><?php echo $post->favorite_count;?></a></li>
            	<div class="clear"></div>
            </ul>
            <div class="sharebox">
                <div id="bdshare" class="bdshare_t bds_tools get-codes-bdshare" data="">
                    <a class="bds_renren">人人网</a>
                    <a class="bds_sqq">QQ好友</a>
                    <a class="bds_huaban">花瓣网</a>
                    <a class="bds_tqq">腾讯微博</a>
                    <a class="bds_qzone">QQ空间</a>
                    <a class="bds_tsina">新浪微博</a>
                    <div class="arrow site-bg"></div>
                </div>
            </div>
        </div>
        <div class="line3px"></div>
        <!-- 个性化推荐 start -->
        <script type="text/javascript" id="wumiiRelatedItems"></script>
        <div class="content-block cnzz-box">
            <script  type="text/javascript" charset="utf-8"  src="http://tui.cnzz.net/cs.php?id=1000021164"></script>
        </div>
        <!-- 个性化推荐 start -->
        <a name="comments"></a>
        <div class="comment-list bottom15px">
        <?php $this->renderPartial('/comment/create', array('postid'=>(int)$post->id));?>
        <?php $this->renderPartial('/comment/list', array('comments'=>$comments, 'pages'=>$pages));?>
        </div>
	</div>
</div>

<div class="fright cd-sidebar">
    <div class="panel panel10 thumb-posts">
        <div class="next-posts">
            <?php if ($prevUrl):?><a href="<?php echo $prevUrl;?>" class="fleft site-bg button">上一个</a><?php endif;?>
            <?php if ($nextUrl):?><a href="<?php echo $nextUrl;?>" class="fleft site-bg button">下一个</a><?php endif;?>
            <a href="<?php echo $returnUrl;?>" class="fright site-bg button">返回列表</a>
            <div class="clear"></div>
        </div>
        <?php foreach ($nextPosts as $next):?>
        <div class="thumb">
            <?php echo $next->getSquareThumbLink('_self');?>
        </div>
        <?php endforeach;?>
        <div class="clear"></div>
    </div>
    
    <!-- 详情页侧边栏广告位开始 -->
    <?php $this->widget('CDAdvert', array('solt'=>'sidebar_post_detail_first'));?>
    <!-- 详情页侧边栏广告位结束 -->
	<div class="panel panel15 bottom15px"><?php $this->widget('CDHotTags', array('title'=>'热门标签'));?></div>
    <!-- 详情页侧边栏广告位开始 -->
    <?php $this->widget('CDAdvert', array('solt'=>'sidebar_post_detail_second'));?>
    <!-- 详情页侧边栏广告位结束 -->
</div>
<div class="clear"></div>

<!-- wumii start -->
<script type="text/javascript">
    var wumiiPermaLink = "<?php echo $post->url;?>";
    var wumiiTitle = <?php echo json_encode($post->getFilterTitle());?>;
    var wumiiTags = <?php echo json_encode($post->getTagText(','));?>;
    var wumiiSitePrefix = "http://www.waduanzi.com/";
    var wumiiParams = "&num=5&mode=2&pf=JAVASCRIPT";
</script>
<script type="text/javascript" src="http://widget.wumii.com/ext/relatedItemsWidget"></script>
<a href="http://www.wumii.com/widget/relatedItems" style="border:0;">
    <img src="http://static.wumii.com/images/pixel.png" alt="无觅相关文章插件，快速提升流量" style="border:0;padding:0;margin:0;" />
</a>
<!-- wumii end -->

<script type="text/javascript">
$(function(){
	var postid = <?php echo $post->id;?>;
	Waduanzi.IncreasePostViewNums(postid, '<?php echo aurl('post/views');?>');
	$(document).on('click', '.comment-arrows a', Waduanzi.RatingComment);
    Waduanzi.setPrevNextButtonPosition();
    
    $('.item-toolbar').on('click', 'a.upscore, a.downscore', Waduanzi.ratingPost);
	$('.item-toolbar').on('mouseenter', 'a.share, .sharebox', Waduanzi.showShareBox);
	$('.item-toolbar').on('mouseleave', 'a.share, .sharebox', Waduanzi.hideShareBox);
	$('.item-toolbar').on('click', 'a.favorite', Waduanzi.favoritePost);

	$(document).on('click', 'input.submit-comment', Waduanzi.PostComment);
    $(document).on('focusin', 'textarea.comment-content', function(event){
    	var tthis = $(this);
    	tthis.addClass('expand');
        if ($.trim(tthis.val()) == tthis.attr('data-placeholder'))
            tthis.val('');
    });
    $(document).on('focusout', 'textarea.comment-content', function(event){
        var tthis = $(this);
        if ($.trim(tthis.val()).length == 0) {
        	tthis.val(tthis.attr('data-placeholder'));
        	tthis.removeClass('expand');
        }
    });
    $(document).on('scroll', function(event) {
    	Waduanzi.setPrevNextButtonPosition();
    });
    
	var container = $('#comments');
	container.infinitescroll({
    	navSelector: '#page-nav',
    	nextSelector: '#page-nav .next a',
    	itemSelector: '.comment-item',
    	dataType: 'html',
    	infid: 0,
    	loading: {
    		finishedMsg: '已经载入全部内容。',
    		msgText: '正在载入更多内容。。。',
    		img: '<?php echo sbu('images/loading1.gif');?>'
    	}
    },
    function(newElements) {
        var newElems = $(newElements).css({opacity:0});
        newElems.animate({opacity:1});
        container.masonry('appended', newElems, true);

        if (count >= 2) {
        	$(window).unbind('.infscr');
        	$(document).on('click', '#manual-load', function(event){
                container.infinitescroll('retrieve');
                return false;
      	    });
        	$('#manual-load').show();
            count = 0;
        }
        else
            count++;
    });
    
    $(document).ajaxError(function(event, xhr, opt) {
    	if (xhr.status == 404) $('div.pages').remove();
	});
	
});
</script>

<?php cs()->registerScriptFile(sbu('libs/jquery.infinitescroll.min.js'), CClientScript::POS_END);?>

<?php if ($post->channel_id != CHANNEL_DUANZI):?>
<!--cnzz tui-->
<script  type="text/javascript" charset="utf-8"  src="http://tui.cnzz.net/cs.php?id=1000021159"></script>
<!--cnzz tui-->
<?php endif;?>


