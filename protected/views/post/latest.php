<div class="fl cd-container">
	<h2 class="cd-catption">最新段子· · · · · · </h2>
    <?php $this->renderPartial('list', array('models'=>$models, 'pages'=>$pages));?>
</div>

<div class="fr cd-sidebar">
	<div class="content-block">
		<h2 class="content-title">动员令</h2>
		<ul class="site-notice">
			<li><?php echo app()->name;?>正式上线啦！请速来挖啊挖啊挖段子。</li>
			<li>我每天都有很多好段子，想共享一下做点贡献，请点击&nbsp;<a href="<?php echo aurl('post/create');?>">发段子</a></li>
			<li>我每天有很多时间，我想做审核员，请发e-mail到80171597@qq.com</li>
			<li>我已经发过很多段子了，但都需要审核，可以不用审核直接显示吗？也请发e-mail到80171597@qq.com审核成为编辑</li>
		</ul>
	</div>
	<div class="cdc-block">
		<script type="text/javascript">
		<!--
            google_ad_client = "ca-pub-6304134167250488";
            /* onenote_300x250 */
            google_ad_slot = "4559886257";
            google_ad_width = 300;
            google_ad_height = 250;
        //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
	</div>
	<?php $this->widget('CDHotTags', array('title'=>'热门标签'));?>
</div>
<div class="clear"></div>
<div class="cdc-bottom-banner">
	<script type="text/javascript">
		<!--
            google_ad_client = "ca-pub-6304134167250488";
            /* onenote_728x90 */
            google_ad_slot = "8095191720";
            google_ad_width = 728;
            google_ad_height = 90;
        //-->
        </script>
        <script type="text/javascript" src="http://pagead2.googlesyndication.com/pagead/show_ads.js"></script>
</div>
<div class="clear"></div>