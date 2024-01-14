<?php
/********************
Template Name: コラム（全件一覧）
*********************/
include("header.php");
?>
<div class="titleBlock titleBlock--L">
  <ul class="topicPath">
    <li><a href="/">TOP</a></li>
    <li><a href="/column/">富士山の天然水とのくらし</a></li>
    <li>記事一覧</li>
  </ul>
  <p class="enTitle">Point of the Water</p>
  <h1>記事一覧</h1>
</div>

<div id="contentsWrap">
<div class="contents">
<?php $numposts = $wpdb->get_var("SELECT count(*) FROM $wpdb->posts WHERE post_status = 'publish' AND post_type = 'column'"); ?>
<?php if (0 < $numposts){
    $numposts = number_format($numposts);
    echo '<h2 class="deviceTtl02">すべての記事 ' . $numposts . '件</h2>';
}
?>
<div class="columnList columnList--sp2pc4 mbL">
    <ul>
      <?php
$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => 100,
];

$related_cats_query = new WP_Query($args);
?>

  <?php if ($related_cats_query->have_posts()) : ?>

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
    </ul>
  </div>

</div>
</div>      
      
<ul class="imgNav01">
    <li class="imgNav01__item1"><a href="/natural_mineral_water/">
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

<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>
<?php include("footer.php");?>