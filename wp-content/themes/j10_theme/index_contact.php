<?php
/********************
Template Name: お問い合わせ
*********************/
include("header.php");
?>
<div class="titleBlock">
  <h1><?php the_title(); ?></h1>
</div>

<div id="contentsWrap">
<div class="contents pcW800">

<div class="contactTtlWrap">
<h2 class="deviceTtl02">フォームで問い合わせ</h2>
<p class="notice">※は必須です</p>
</div>

<p class="errorBox">未入力の項目をご確認ください。</p>

   <?php
       while ( have_posts() ) : the_post();
       the_content();
       endwhile;
   ?>

<div class="contactWrap">
<h2 class="deviceTtl02 LINE--GT1 mt40 mt60-pc pt60-pc">ウォーターサーバーのお問い合わせ</h2>
<p class="deviceTtl02"><a href="tel:0120-550-381" class="tetxUL">お電話 0120-550-381</a></p>
<p class="deviceTtl02"><a href="mailto:info@mt-fuji-grs.co.jp" class="tetxUL">メール info@mt-fuji-grs.co.jp</a></p>

<h2 class="deviceTtl02 LINE--GT1 mt40 mt60-pc pt60-pc">ペットボトル、その他のお問い合わせ</h2>
<p class="deviceTtl02"><a href="tel:0120-328-311" class="tetxUL">お電話 0120-328-311</a></p>
<p class="deviceTtl02"><a href="mailto:info123@mt-fuji-nmw.com" class="tetxUL">メール info123@mt-fuji-nmw.com</a></p>
</div>

<!--.contents--></div>
<!--.contentsWrap--></div>

<div class="columnView">
  <h2 class="columnView__title">Column<strong>水の豆知識</strong></h2>
  <div class="scrollWrap">
  <?php
$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => '10', // 表示する記事数を指定
  'meta_key' => 'water', //カスタムフィールドのキー
  'meta_value' => '1',
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
      <div class="columnList__items__date"><?php echo get_the_date( 'Y.m.d' ); ?></div>
       </a></li>
      <?php endwhile; ?>
</ul>
  <?php else : ?>
    
  <?php
  endif;
  wp_reset_postdata(); ?>
  <p class="columnView__button"><a href="/column/" class="btnType02">水の豆知識をもっと見る</a></p>
</div>
</div>

<?php get_sidebar(); ?>

<?php include("footer.php");?>