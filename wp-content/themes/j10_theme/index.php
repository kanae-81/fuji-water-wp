<?php
/********************
Main
*********************/
include("header.php");
?>

<?php $text_field = get_field('text_field'); ?>
<?php if(post_custom('entitle')): ?>
<div class="titleBlock titleBlock--L"> 
<p class="enTitle"><?php the_field('entitle'); ?></p>
<?php else: ?>   
<div class="titleBlock"> 
<?php endif; ?>
<h1><?php the_title(); ?></h1>
   
<?php if(is_page('privacy_policy') || is_parent_slug() === 'privacy_policy'): ?>
<div class="frameTab">
  <ul class="frameTab__menu">
    <li class="cur">富士山の天然水</li>
    <li class="">富士山の源流水</li>
  </ul>
</div>
<?php endif; ?>
<?php if(is_page('customer_term') || is_parent_slug() === 'customer_term'): ?>
<div class="frameTab">
  <ul class="frameTab__menu">
    <li class="cur">富士山の源流水</li>
    <li class="">みんなの家庭の医学</li>
    <li class="">健康相談</li>
  </ul>
</div>   
<?php endif; ?>
   
</div>

<div id="contentsWrap">
<?php if(is_page('company') || is_parent_slug() === 'company'): ?>
<div class="contents pb0">
<?php else: ?>
<div class="contents">
<?php endif; ?>


   <?php
       while ( have_posts() ) : the_post();
       the_content();
       endwhile;
   ?>

		
<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>

<?php include("footer.php");?>