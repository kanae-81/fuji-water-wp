<?php
/********************
Template Name: トップページ
*********************/
include("header.php"); ?>

<?php the_field('page1', false, false ); ?>

    <div class="columnView wideSection originalBG03">
      <h2 class="columnView__title">Column<strong>ウォーターサーバーとのくらし</strong></h2>
      <div class="scrollWrap scrollCsettings">

<?php
$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => '10', // 表示する記事数を指定
  'category__in' => '4', // カテゴリーIDを指定
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
    <p class="btnType02Wrap mt40"><a href="/water_server/" class="btnType06">ウォーターサーバーをもっと知る</a></p>
    </div>

<?php the_field('page2', false, false ); ?>

    <?php /*?><div class="columnView wideSection originalBG02">
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
</div>
</ul>
  <?php else : ?>
    
  <?php
  endif;
  wp_reset_postdata(); ?>
    </div><?php */?>

    <?php the_field('page3', false, false ); ?>

    <div class="mt80">
      <h2 class="topTitle layoutCPC"><span class="topTitle__en">Column</span>富士山の天然水とくらす</h2>
  
      <div class="columnList columnList--sp1pc3 mbL">
        <?php
$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => '3', // 表示する記事数を指定
  'category__in' => '11', // カテゴリーIDを指定
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

<?php the_field('page4', false, false ); ?>

    <div class="pcW800 mt80">
    <h2 class="topTitle"><span class="topTitle__en">NEWS</span>ニュース</h2>

    <ul class="newsList">
      <?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $mypost = array(
		'posts_per_page'   => 3,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'news',
		'post_status'      => 'publish',
		'ignore_sticky_posts' => 1,
		'paged'            =>  $paged
);
$the_query = new WP_Query($mypost);
?>
<?php if ($the_query->have_posts()): while ($the_query->have_posts()): $the_query->the_post(); ?>
<?php 
	global $post;
	$post_id = $post->ID;
?>
<?php echo get_field('customfield',$post_id); ?>
   <li><a href="<?php the_permalink(); ?>">
      <span class="newsList__data"><?php echo get_the_date( 'Y.m.d' ); ?></span>
      <span class="newsList_title"><?php the_title(); ?></span>
       </a></li>
     
<?php endwhile;?>
</ul>

<?php wp_reset_query(); ?>
<?php endif; ?>

    <p class="btnType02Wrap mt40"><a href="/news/" class="btnType03">一覧で見る</a></p>
  </div>

  <!--.contents--></div>
  <!--.contentsWrap--></div>
  
  
<?php include("footer.php");?>
