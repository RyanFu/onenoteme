<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ((array)$tags as $tag):?>
<url>
    <loc><?php echo aurl('tag/posts', array('name'=>$tag['name']));?></loc>
    <priority>0.90</priority>
</url>
<?php endforeach;?>
</urlset>
