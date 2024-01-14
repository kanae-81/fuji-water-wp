<?php
/********************
Template Name: お見積り
*********************/
include("header.php");
?>

<div class="titleBlock">
  <h1><?php the_title(); ?></h1>
</div>

<div id="contentsWrap">
<div class="contents pcW800">

<div class="contactTtlWrap">
<p class="errorBox">未入力の項目をご確認ください。</p>
<p class="confirmHide">お見積もりご依頼の情報を入力してください。</p>
<h2 class="deviceTtl02 LINE--GT1 mt40">ペットボトルの形</h2>
<p class="confirmHide">ご希望の本数が最小ロット数に満たない場合も、ご相談可能なことがあります。お気軽にお問い合わせください。</p>
</div>

   <?php
       while ( have_posts() ) : the_post();
       the_content();
       endwhile;
   ?>

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