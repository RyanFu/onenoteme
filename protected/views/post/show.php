<div class="fleft cd-container">
	<div class="panel panel20 post-detail">
		<div class="content-block post-content">
		    <p><?php echo $post->filterContent;?></p>
		    <?php if ($post->tags):?><div class="post-tags">标签：<?php echo $post->tagLinks;?></div><?php endif;?>
        </div>
        <?php if ($post->videoHtml):?>
        <div class="content-block video-player"><?php echo $post->videoHtml;?></div>
        <?php elseif ($post->bmiddlePic):?>
        <div class="content-block post-picture"><?php echo l(CHtml::image($post->bmiddlePic, $post->filterContent . ', ' . $post->getTagText(',')), aurl('post/originalpic', array('id'=>$post->id)), array('target'=>'_blank', 'title'=>$post->filterContent));?></div>
        <?php endif;?>
        <?php if ($post->channel_id == CHANNEL_DUANZI):?>
        <ul class="cdc-block">
            <li><a target="_blank" href="http://s.click.taobao.com/t_8?e=7HZ6jHSTbIg8q6nQGu%2B62FZKBlLXgG2mwcp6cvy9HYCgmQ%3D%3D&p=mm_12551250_0_0">公猴英伦休闲女鞋休闲鞋女单鞋小白鞋小白皮鞋平底时尚单鞋女051</a></li>
            <li><a target="_blank" href="http://s.click.taobao.com/t_8?e=7HZ6jHSTbIlJ0FqabRsutUHqDnE4%2B79bP24MnZw9DcCG7w%3D%3D&p=mm_12551250_0_0">【倔强的偏执】中长袖连衣裙秋装新款 秋款秋连衣裙OL1518</a></li>
            <li><a target="_blank" href="http://s.click.taobao.com/t_8?e=7HZ6jHSTbIg8oI%2FbUXjChSS8HRuUVdw7bnV4OoAz1vtquA%3D%3D&p=mm_12551250_0_0">淘金币 2012春秋装新款连衣裙韩版V领毛衣裙子 时尚女装修身连衣</a></li>
        </ul>
        <?php endif;?>
        <div class="toolbar radius3px">
    		<div class="content-block post-arrows fleft">
                <a class="site-bg arrow-up" data-id="<?php echo $post->id;?>" data-value="1" data-url="<?php echo aurl('post/score');?>" href="javascript:void(0);">喜欢</a>
                <a class="site-bg arrow-down" data-id="<?php echo $post->id;?>" data-value="0" data-url="<?php echo aurl('post/score');?>" href="javascript:void(0);">讨厌</a>
                <div class="clear"></div>
            </div>
            <div class="content-block info fleft">
                评分:<span id="score-count"><?php echo $post->score;?></span>&nbsp;&nbsp;
                浏览:<span id="view-count"><?php echo (int)$post->view_nums;?></span>&nbsp;&nbsp;
                喜欢:<span id="like-count"><?php echo (int)$post->up_score;?></span>
            </div>
            <div class="content-block social fright">
                <!-- JiaThis Button BEGIN -->
                <div id="jiathis_style_32x32">
                <a class="jiathis_button_qzone"></a>
                <a class="jiathis_button_tsina"></a>
                <a class="jiathis_button_tqq"></a>
                <a class="jiathis_button_renren"></a>
                <a class="jiathis_button_kaixin001"></a>
                <a href="http://www.jiathis.com/share?uid=1622045" class="jiathis jiathis_txt jiathis_separator jtico jtico_jiathis" target="_blank"></a>
                </div>
                <script type="text/javascript" >
                var jiathis_config={
                	data_track_clickback:true,
                	title: '<?php echo h($post->filterContent)?>',
                	pic: '<?php echo $post->bmiddlePic;?>',
                	ralateuid:{
                		"tsina":"1639121454"
                	},
                	appkey:{
                		"tsina":"2981913360",
                		"tqq":"801092195",
                		"t163":"Cwn0IrjtEY6KHD6m",
                		"tsouhu":"dze98woifnwQGH4wN0QL"
                	},
                	hideMore:true
                }
                </script>
                <script type="text/javascript" src="http://v2.jiathis.com/code/jia.js?uid=1622045" charset="utf-8"></script>
                <!-- JiaThis Button END -->
            </div>
            <div class="clear"></div>
        </div>
        <?php if ($post->bmiddlePic):?>
        <div class="content-block wumii-box">
            <script type="text/javascript" id="wumiiRelatedItems"></script>
        </div>
        <?php endif;?>
        <form action="<?php echo aurl('comment/create');?>" method="post" class="content-block comment-form" id="comment-form">
            <input type="hidden" name="postid" value="<?php echo $post->id;?>" />
            <textarea name="content" id="comment-content" class="mini-content fleft radius3px">请输入评论内容。。。</textarea>
            <input type="button" id="submit-comment" value="发表" class="button site-bg fright" />
            <div class="clear"></div>
            <span class="counter">140</span>
            <div class="save-caption-loader hide"></div>
        </form>
        <div id="caption-error" class="content-block hide"></div>
        <div id="comments">
        <?php $this->renderPartial('/comment/list', array('comments'=>$comments, 'pages'=>$pages));?>
        </div>
	</div>
</div>

<div class="fright cd-sidebar">
    <div class="panel panel10 next-posts">
        <div class="post-nav">
            <?php if ($prevUrl):?><a href="<?php echo $prevUrl;?>" class="fleft site-bg button">上一个</a><?php endif;?>
            <?php if ($nextUrl):?><a href="<?php echo $nextUrl;?>" class="fleft site-bg button">下一个</a><?php endif;?>
            <a href="<?php echo $returnUrl;?>" class="fright site-bg button">返回列表</a>
            <div class="clear"></div>
        </div>
        <?php foreach ((array)$nextPosts as $next):?>
        <?php if ($next->channel_id != CHANNEL_DUANZI && $next->channel_id != CHANNEL_VIDEO):?>
        <div class="thumb">
            <?php echo $next->getThumbnailLink('_self');?>
        </div>
        <?php endif;?>
        <?php endforeach;?>
        <div class="clear"></div>
    </div>
    <?php if ($post->bmiddlePic):?>
    <div class="cdc-block">
        <script type="text/javascript">
        alimama_pid="mm_12551250_2904829_10392377";
        alimama_width=300;
        alimama_height=250;
        </script>
        <script src="http://a.alimama.cn/inf.js" type="text/javascript"></script>
    </div>
    <?php endif;?>
	<div class="panel panel15"><?php $this->widget('CDHotTags', array('title'=>'热门标签'));?></div>
</div>
<div class="clear"></div>

<?php if ($post->bmiddlePic):?>
<script type="text/javascript">
    netease_union_user_id = 6156606;
    netease_union_site_id = 25143;
    netease_union_worktype = null;
    netease_union_promote_type = 5;
    netease_union_width = 250;
    netease_union_height = 200;
    netease_union_link_id = null;
    netease_union_cpv_type = 0;
</script>
<script type="text/javascript" src="http://union.netease.com/sys_js/display.js"></script>
<?php endif;?>

<script type="text/javascript">
    var wumiiPermaLink = '<?php echo $post->url;?>';
    var wumiiTitle = '<?php echo json_encode($post->filterContent);?>';
    var wumiiTags = '<?php echo json_encode($post->getTagText(','));?>';
    var wumiiSitePrefix = "http://www.waduanzi.com/";
    var wumiiParams = "&num=5&mode=2&pf=JAVASCRIPT";
</script>
<script type="text/javascript" src="http://widget.wumii.com/ext/relatedItemsWidget"></script>
<a href="http://www.wumii.com/widget/relatedItems" style="border:0;">
    <img src="http://static.wumii.com/images/pixel.png" alt="无觅相关文章插件，快速提升流量" style="border:0;padding:0;margin:0;" />
</a>

<script type="text/javascript">
$(function(){
	var postid = <?php echo $post->id;?>;
	Waduanzi.IncreasePostViewNums(postid, '<?php echo aurl('post/views');?>');
	var commentInitVal = $('#comment-content').val();
    $('.post-detail').on('click', '.post-arrows a', Waduanzi.RatingPost);
    $('.post-detail').on('click', '.comment-arrows a', Waduanzi.RatingComment);
    Waduanzi.AjustImgWidth($('.post-picture img'), 600);
    $('.post-detail').on('focus', '#comment-content', function(event){
        $(this).addClass('expand');
        if ($.trim($(this).val()) == commentInitVal)
            $(this).val('');
    });
    $('.post-detail').on('blur', '#comment-content', function(event){
        if ($.trim($(this).val()).length == 0) {
            $(this).val(commentInitVal);
            $(this).removeClass('expand');
        }
    });
    $('.post-detail').on('click', '#submit-comment', Waduanzi.PostComment);

    
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


