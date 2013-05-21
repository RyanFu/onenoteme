<div class="fleft cd-container">
<?php $this->renderPartial('/post/line_list', array('models' => $models, 'pages' => $pages));?>
</div>
<div class="fright cd-sidebar">
    <!-- 首页侧边栏广告位1 开始 -->
    <?php $this->widget('CDAdvert', array('solt'=>'home_sidebar_first'));?>
    <!-- 首页侧边栏广告位1 结束 -->
    <div class="panel panel10 bottom15px">
        <iframe width="270" height="250" frameborder="0" scrolling="no" src="http://app.wumii.com/ext/widget/hot?prefix=http%3A%2F%2Fwww.waduanzi.com%2F&num=10&t=1"></iframe>
    </div>
    <div class="cdc-block cd-border app-list">
        <a href="http://itunes.apple.com/cn/app//id486268988?mt=8" target="_blank" title="挖段子iPhone应用, 最新版本 2.2.2"><img src="<?php echo sbu('images/app_ios.png');?>" alt="挖段子iPhone应用" /></a>
        <a href="<?php echo sbu('android/waduanzi.apk');?>" target="_blank" title="挖段子Andoird应用 最新版本 1.1.0"><img src="<?php echo sbu('images/app_android.png');?>" alt="挖段子Andoird应用" /></a>
        <a href="<?php echo CDBaseUrl::mobileHomeUrl();?>" target="_blank" title="挖段子手机版网站"><img src="<?php echo sbu('images/mobile_site.png');?>" alt="挖段子手机版网站" /></a>
    </div>
    <?php $this->renderPartial('/public/snsinfo');?>
    
    <div class="panel panel15 bottom15px"><?php $this->widget('CDHotTags', array('title'=>'热门标签'));?></div>
    <!-- 首页侧边栏广告位2 开始 -->
    <?php $this->widget('CDAdvert', array('solt'=>'home_sidebar_second'));?>
    <!-- 首页侧边栏广告位2 结束 -->
    <!-- 最新笑话 开始 -->
    <?php $this->widget('CDPostSearch', array('title'=>'最新内涵图', 'channel'=>CHANNEL_FUNNY, 'mediaType'=>MEDIA_TYPE_IMAGE));?>
    <!-- 最新笑话 结束 -->
</div>
<div class="clear"></div>

<?php $this->widget('CDLinks', array('ishome'=>1, 'count'=>40));?>


