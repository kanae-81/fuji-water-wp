<?php
/********************
News
*********************/
include("header.php");
?>

<?php $text_field = get_field('text_field'); ?>
<div class="titleBlock">
  <p class="title">ニュース</p>

</div>

<div id="contentsWrap">
<div class="contents">
   
   <div class="newsEntry">
    <div class="newsEntry__head">
      <h1 class="newsEntry__head__title"><?php the_title(); ?></h1>
      <p class="newsEntry__head__date"><?php echo get_the_date( 'Y.m.d' ); ?></p>
    </div>
    <div class="newsEntry__body">
      <?php
       while ( have_posts() ) : the_post();
       the_content();
       endwhile;
      ?>
    </div>
    <div class="newsEntry__footer">
      <ul class="newsEntry__footer__nav">
        <?php if (get_previous_post()):?>
         <li class="newsEntry__footer__nav--prev">
         <?php previous_post_link('%link', 'BACK'); ?>
         </li>
         <?php endif; ?>
         <li class="newsEntry__footer__nav--list"><a href="/news/">ニュース一覧へ</a></li>
         <?php if (get_next_post()):?>
         <li class="newsEntry__footer__nav--next">
         <?php next_post_link('%link', 'NEXT'); ?>
         </li>
         <?php endif; ?>   
      </ul>
    </div>
  </div>

<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>

<?php include("footer.php");?>