<?php
/********************
Template Name: 富士山の天然水とは
*********************/
include("header.php");
?>

   <?php
       while ( have_posts() ) : the_post();
       the_content();
       endwhile;
   ?>

<div class="mt80">
    <h2 class="topTitle layoutCPC"><span class="topTitle__en">Column</span>富士山の天然水とくらす</h2>

    <div class="columnList columnList--sp1pc3 mbL">
      <?php
$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => '3', // 表示する記事数を指定
  'category__in' => '8', // カテゴリーIDを指定
];

$related_cats_query = new WP_Query($args);
?>

  <?php if ($related_cats_query->have_posts()) : ?>
   
    <ul>
      <?php while ($related_cats_query->have_posts()) : $related_cats_query->the_post(); ?>
      <?php $text_field = get_field('text_field'); ?>
      <li class="columnList__items"><a href="<?php the_permalink(); ?>">
      <div class="columnList__items__thumb"><?php the_post_thumbnail(); ?></div>
      <div class="columnList__items__text"><?php the_title(); ?></div>
      <div class="columnList__items__label">
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
      <div class="columnList__items__date"><?php echo get_the_date( 'Y.m.d' ); ?></div>
       </a></li>
      <?php endwhile; ?>
</ul>
  <?php else : ?>
    
  <?php
  endif;
  wp_reset_postdata(); ?>
      <p class="btnType02Wrap mt40"><a href="/column/" class="btnType03">一覧で見る</a></p>
    </div>      
  </div>

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

<?php include("footer.php");?>