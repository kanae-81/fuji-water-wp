<?php
/********************
Template Name: オリジナルラベルボトル
*********************/
include("header.php");
?>

   <?php
       while ( have_posts() ) : the_post();
       the_content();
       endwhile;
   ?>

<?php /*?><!--<div class="columnView wideSection originalBG02">
   <h2 class="columnView__title">Column<strong>オリジナルぺットボトルの<br class="spOnlyI">活用</strong></h2>
   <div class="scrollWrap">

      <?php
$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => '10', // 表示する記事数を指定
  'category__in' => '10', // カテゴリーIDを指定
];

$related_cats_query = new WP_Query($args);
?>

  <?php if ($related_cats_query->have_posts()) : ?>
   
    <ul>
      <?php while ($related_cats_query->have_posts()) : $related_cats_query->the_post(); ?>
      <?php $text_field = get_field('text_field'); ?>
      <li class="columnView__items"><a href="<?php the_permalink(); ?>">
      <div class="columnView__items__thumb"><?php the_post_thumbnail(); ?></div>
      <div class="columnView__items__text"><?php the_title(); ?></div>
      <div class="columnView__items__label">
<?php
$x=1;
$num=3;
$categories = get_the_category();
if ( $categories ) {
	foreach ( $categories as $category ) {
      if ( $x>=$num ) { // 指定した数とマッチしたら終了
         break;
       } else { // 指定した数とマッチしなかったら表示
         echo '<span>'.$category->name.'</span>';
       }
      $x++;
	}
}
?>
</div>
      <div class="columnView__items__date"><?php echo get_the_date( 'Y.m.d' ); ?></div>
       </a></li>
      <?php endwhile; ?>
</ul>
  <?php else : ?>
    
  <?php
  endif;
  wp_reset_postdata(); ?>
</div>
</div>--><?php */?>      
      
<ul class="imgNav01">
    <li class="imgNav01__item1"><a href="/water_server/">
      <div class="imgNav01__text">ウォーターサーバーで<br>天然水を飲む</div>
      <div class="imgNav01__icon"><img src="/common/img/icon_badge_01.png" alt="優秀味覚賞受賞"></div>
    </a></li>
    <li class="imgNav01__item2"><a href="/bottle/">
      <div class="imgNav01__text">オリジナルペットボトルを作る</div>
    </a></li>
    <li class="imgNav01__item3"><a href="https://mtfujinmw.base.shop/" target="_blank">
      <div class="imgNav01__text">ペットボトルで<br>天然水を飲む</div>
    </a></li>
  </ul>

<?php the_field('company', false, false ); ?>

<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>
<p class="frameBTN"><a href="/estimate/">お見積もりフォーム</a></p>
<?php include("footer.php");?>