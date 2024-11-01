<?php
/**
* 
* smartFolio v3.0
* Album Template. Lots of stuff below.
* 
* Last Update: Version 0.1
* 
**/ 
?>

<?php get_header(); ?>
<?php
//Add Additional Stylesheet & JS to Template Generated Pages and Posts
$prop_pluginsurl = plugins_url();
?>
<!---BEGIN CONTENT-->
<div class="content">
<div class="content_top">
        <h2><?php echo $smf_album_title; ?></h2>
</div>
        <ul class="album">
<?php
$args = array('post_type' => 'smartfolios', 'numberposts' => 50, 'orderby' => 'rand' );
$rand_posts = get_posts ( $args );
        global $post; 

foreach ($rand_posts as $post) : setup_postdata($post); ?>
<?php
        global $post; 
	    $custom = get_post_custom($post->ID); 
	    $albumslug = basename(get_permalink()); 
            $smf_album_title = $custom["smf_album_title"][0]; 
            $smf_image_title = $custom["smf_image_title"][0]; 
            $smf_image_desc = $custom["smf_image_desc"][0];
            $smf_image_src = $custom["smf_image_src"][0];
                    
?>      <li>
        <span><?php echo $smf_album_title; ?></span>
        <a href="<?php echo $albumslug; ?>"><img src="<?php echo $smf_image_src; ?>" alt="<?php echo $smf_image_desc; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow_wide.png" alt="" title="" border="0" class="shadow" />
	</li>
<?php endforeach; ?>
	</ul>
	<div class="clear"></div> 
		</div>
</div>
   
<!---END CONTENT-->
        
<?php get_footer(); ?>
  
<!-- Main CSS file -->
<link rel="stylesheet" href="<?php echo $prop_pluginsurl ?>/smartfolio/css/add2style.css" type="text/css" media="screen" />
<!-- Google web font -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
<!-- jQuery file -->
<script src="<?php echo $prop_pluginsurl ?>/smartfolio/js/jquery.min.js"></script>
<!-- Main effects files -->
<script src="<?php echo $prop_pluginsurl ?>/smartfolio/js/effects.js"></script>
<!-- PrettyPhoto -->
<script src="<?php echo $prop_pluginsurl ?>/smartfolio/js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" href="<?php echo $prop_pluginsurl ?>/smartfolio/js/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
<style type="text/css">
a.c1 {
    background-color: #0074CC;
    border: 1px groove royalblue;
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25), 0 -1px 0 rgba(0, 0, 0, 0.1) inset;
    color: #FFFFFF;
    display: block;
    margin-top: -12px;
    padding: 8px 20px;
    position: static;
    text-align: center;
    text-decoration: none;
    width: 100px;
}
</style>
