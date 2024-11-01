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
<?php
//Add Additional Stylesheet & JS to Template Generated Pages and Posts
$prop_pluginsurl = plugins_url();
?>
<?php get_header(); ?>

<?php
	    $custom = get_post_custom($post->ID);  
            $smf_album_title = $custom["smf_album_title"][0]; 
            $smf_image_title = $custom["smf_image_title"][0]; 
            $smf_image_desc = $custom["smf_image_desc"][0];
            $smf_image_src = $custom["smf_image_src"][0];
            $smf_image_title2 = $custom["smf_image_title2"][0]; 
            $smf_image_desc2 = $custom["smf_image_desc2"][0]; 
            $smf_image_src2 = $custom["smf_image_src2"][0];
            $smf_image_title3 = $custom["smf_image_title3"][0]; 
            $smf_image_desc3 = $custom["smf_image_desc3"][0]; 
            $smf_image_src3 = $custom["smf_image_src3"][0];
            $smf_image_title4 = $custom["smf_image_title4"][0]; 
            $smf_image_desc4 = $custom["smf_image_desc4"][0]; 
            $smf_image_src4 = $custom["smf_image_src4"][0];
            $smf_image_title5 = $custom["smf_image_title5"][0]; 
            $smf_image_desc5 = $custom["smf_image_desc5"][0]; 
            $smf_image_src5 = $custom["smf_image_src5"][0];
            $smf_image_title6 = $custom["smf_image_title6"][0]; 
            $smf_image_desc6 = $custom["smf_image_desc6"][0]; 
            $smf_image_src6 = $custom["smf_image_src6"][0];
            $smf_image_title7 = $custom["smf_image_title7"][0]; 
            $smf_image_desc7 = $custom["smf_image_desc7"][0];
            $smf_image_src7 = $custom["smf_image_src7"][0];  
            $smf_image_title8 = $custom["smf_image_title8"][0]; 
            $smf_image_desc8 = $custom["smf_image_desc8"][0];
            $smf_image_src8 = $custom["smf_image_src8"][0];  
            $smf_image_title9 = $custom["smf_image_title9"][0]; 
            $smf_image_desc9 = $custom["smf_image_desc9"][0];
            $smf_image_src9 = $custom["smf_image_src9"][0];  
	    $smf_image_title10 = $custom["smf_image_title10"][0]; 
            $smf_image_desc10 = $custom["smf_image_desc10"][0];
            $smf_image_src10 = $custom["smf_image_src10"][0];
	    $smf_image_title11 = $custom["smf_image_title11"][0]; 
            $smf_image_desc11 = $custom["smf_image_desc11"][0];
            $smf_image_src11 = $custom["smf_image_src11"][0];
            $smf_image_title12 = $custom["smf_image_title12"][0]; 
            $smf_image_desc12 = $custom["smf_image_desc12"][0]; 
            $smf_image_src12 = $custom["smf_image_src12"][0];
            $smf_image_title13 = $custom["smf_image_title13"][0]; 
            $smf_image_desc13 = $custom["smf_image_desc13"][0]; 
            $smf_image_src13 = $custom["smf_image_src13"][0];
            $smf_image_title14 = $custom["smf_image_title14"][0]; 
            $smf_image_desc14 = $custom["smf_image_desc14"][0]; 
            $smf_image_src14 = $custom["smf_image_src14"][0];
            $smf_image_title15 = $custom["smf_image_title15"][0]; 
            $smf_image_desc15 = $custom["smf_image_desc15"][0]; 
            $smf_image_src15 = $custom["smf_image_src15"][0];
            $smf_image_title16 = $custom["smf_image_title16"][0]; 
            $smf_image_desc16 = $custom["smf_image_desc16"][0]; 
            $smf_image_src16 = $custom["smf_image_src16"][0];
            $smf_image_title17 = $custom["smf_image_title17"][0]; 
            $smf_image_desc17 = $custom["smf_image_desc17"][0];
            $smf_image_src17 = $custom["smf_image_src17"][0];  
            $smf_image_title18 = $custom["smf_image_title18"][0]; 
            $smf_image_desc18 = $custom["smf_image_desc18"][0];
            $smf_image_src18 = $custom["smf_image_src18"][0];  
            $smf_image_title19 = $custom["smf_image_title19"][0]; 
            $smf_image_desc19 = $custom["smf_image_desc19"][0];
            $smf_image_src19 = $custom["smf_image_src19"][0];  
	    $smf_image_title20 = $custom["smf_image_title20"][0]; 
            $smf_image_desc20 = $custom["smf_image_desc20"][0];
            $smf_image_src20 = $custom["smf_image_src20"][0];  
                    
?>
<!---BEGIN CONTENT-->
<div class="content">
<div class="content_top">
<a class="c1" href="../portfolio.html">Back</a>
        <h2><?php echo $smf_album_title; ?></h2>
</div>
        <ul class="portfolio">
	<?php if ($smf_image_src != ""): ?>
        <li>
        <span><?php echo $smf_image_title; ?></span>
        <a href="<?php echo $smf_image_src; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src; ?>" alt="<?php echo $smf_image_desc; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src2 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title2; ?></span>
        <a href="<?php echo $smf_image_src2; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src2; ?>" alt="<?php echo $smf_image_desc2; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>
	<?php if ($smf_image_src3 != ""): ?>
        <li>
        <span><?php echo $smf_image_title3; ?></span>
        <a href="<?php echo $smf_image_src3; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src3; ?>" alt="<?php echo $smf_image_desc3; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src4 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title4; ?></span>
        <a href="<?php echo $smf_image_src4; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src4; ?>" alt="<?php echo $smf_image_desc4; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>        
	<?php if ($smf_image_src5 != ""): ?>
        <li>
        <span><?php echo $smf_image_title5; ?></span>
        <a href="<?php echo $smf_image_src5; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src5; ?>" alt="<?php echo $smf_image_desc5; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src6 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title6; ?></span>
        <a href="<?php echo $smf_image_src6; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src6; ?>" alt="<?php echo $smf_image_desc6; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>        
	<?php if ($smf_image_src7 != ""): ?>
        <li>
        <span><?php echo $smf_image_title7; ?></span>
        <a href="<?php echo $smf_image_src7; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src7; ?>" alt="<?php echo $smf_image_desc7; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src8 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title8; ?></span>
        <a href="<?php echo $smf_image_src8; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src8; ?>" alt="<?php echo $smf_image_desc8; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>
	<?php if ($smf_image_src9 != ""): ?>
        <li>
        <span><?php echo $smf_image_title9; ?></span>
        <a href="<?php echo $smf_image_src9; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src9; ?>" alt="<?php echo $smf_image_desc9; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src10 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title10; ?></span>
        <a href="<?php echo $smf_image_src10; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src10; ?>" alt="<?php echo $smf_image_desc10; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>        
	<?php if ($smf_image_src11 != ""): ?>
        <li>
        <span><?php echo $smf_image_title11; ?></span>
        <a href="<?php echo $smf_image_src11; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src11; ?>" alt="<?php echo $smf_image_desc11; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src12 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title12; ?></span>
        <a href="<?php echo $smf_image_src12; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src12; ?>" alt="<?php echo $smf_image_desc12; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>        
	<?php if ($smf_image_src13 != ""): ?>
        <li>
        <span><?php echo $smf_image_title13; ?></span>
        <a href="<?php echo $smf_image_src13; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src13; ?>" alt="<?php echo $smf_image_desc13; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src14 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title14; ?></span>
        <a href="<?php echo $smf_image_src14; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src14; ?>" alt="<?php echo $smf_image_desc14; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>        
	<?php if ($smf_image_src15 != ""): ?>
        <li>
        <span><?php echo $smf_image_title15; ?></span>
        <a href="<?php echo $smf_image_src15; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src15; ?>" alt="<?php echo $smf_image_desc15; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src16 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title16; ?></span>
        <a href="<?php echo $smf_image_src16; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src16; ?>" alt="<?php echo $smf_image_desc16; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>
        <?php if ($smf_image_src17 != ""): ?>
        <li>
        <span><?php echo $smf_image_title17; ?></span>
        <a href="<?php echo $smf_image_src17; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src17; ?>" alt="<?php echo $smf_image_desc17; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src18 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title18; ?></span>
        <a href="<?php echo $smf_image_src18; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src18; ?>" alt="<?php echo $smf_image_desc18; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>        
	<?php if ($smf_image_src19 != ""): ?>
        <li>
        <span><?php echo $smf_image_title19; ?></span>
        <a href="<?php echo $smf_image_src19; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src19; ?>" alt="<?php echo $smf_image_desc19; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
	</li>
	<?php endif; ?>        
	<?php if ($smf_image_src20 != ""): ?>
	<li class="right">
        <span><?php echo $smf_image_title20; ?></span>
        <a href="<?php echo $smf_image_src20; ?>" rel="prettyPhoto[gallery]"><img src="<?php echo $smf_image_src20; ?>" alt="<?php echo $smf_image_desc20; ?>" title="" border="0" class="rounded-half" /></a>
        <img src="<?php echo $prop_pluginsurl ?>/smartfolio/images/shadow.png" alt="" title="" border="0" class="shadow" />
        </li>
	<?php endif; ?> 
	<li class="clear"></li>
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
