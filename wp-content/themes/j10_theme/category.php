<?php
/*
Template Name: コラム一覧
*/
include("header.php");
?>

<div class="titleBlock titleBlock--L">
  <ul class="topicPath">
    <li><a href="/">TOP</a></li>
    <li><a href="/column/">富士山の天然水とのくらし</a></li>
    <li><?php single_cat_title(); ?></li>
  </ul>
  <p class="enTitle">Point of the Water</p>
  <h1><?php single_cat_title(); ?></h1>
</div>

<div id="contentsWrap">
<div class="contents">
<div class="pcCellWrap">
<div class="pcCellWrap__main">
<h2 class="deviceTtl02">新着記事</h2>
<div class="columnList columnList--sp2pc3 columnList--pc1stL">
<ul class="columnWidth">

<?php
global $cat;

$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => '10', // 表示する記事数を指定
  'category__in' => $cat
];

$related_cats_query = new WP_Query($args);
?>

<?php if ($related_cats_query->have_posts()) : ?>
<?php while ($related_cats_query->have_posts()) : $related_cats_query->the_post(); ?>
   <li class="columnList__items"><a href="<?php the_permalink(); ?>">
      <div class="columnList__items__thumb"><?php the_post_thumbnail(); ?></div>
      <div class="columnList__items__text"><?php the_title(); ?></div>
      <div class="columnList__items__label">
<?php
$categories = get_the_category();
if ( $categories ) {
	foreach ( $categories as $category ) {
		echo '<span>'.$category->name.'</span>';
	}
}
?>
</div>
      <div class="columnList__items__date"><?php echo get_the_date( 'Y.m.d' ); ?></div>
       </a></li>
<?php endwhile;?>
</ul>
</div>

<?php
  $pages = $related_cats_query->max_num_pages;
  $showItems = 5;
  if($pages != 0 && $pages != 1) {
    echo '<div class="pager"><ul class="pager__inner">';
    if($paged != 1) {
      echo '<li class="pager__before"><a href="'.get_pagenum_link($paged - 1).'">BACK</a></li>';
	}else{
	  echo '';
	}
    for($index = 1; $index <= $pages; $index++) {
	  if($index <= $showItems) {
		  if($index == $paged) {
			// current
			echo '<li class="pager__cur"><span>'.$paged.'</span></li>';
		  } else {
			echo '<li><a href="'.get_pagenum_link($index).'">'.($index).'</a></li>'; 
		  }
	  }
    }
    if($paged != $pages) {
      echo '<li class="pager__next"><a href="'.get_pagenum_link($paged + 1).'">NEXT</a></li>';
	}else{
	  echo '';
	} 
    echo "</ul>\n";
    echo "</div>\n";
  }
?> 
<?php wp_reset_query(); ?>
<?php endif; ?>
   
<h2 class="deviceTtl02 LINE--GT1L">カテゴリ</h2>
<div class="scrollWrap pcNoscroll">
<ul class="categoryNav">
<?php  
$terms = get_categories();
if ( ! empty( $terms ) && ! is_wp_error( $terms ) ){
        foreach ( $terms as $term ) {
            echo '<li><a href="'.get_category_link($term->term_id).'"><span class="thumb">'.get_term_thumbnail($term->term_id).'</span><span>'.$term->name.'</span></a></li>';
    }
}
?>

</ul>
</div>

<p class="btnType02Wrap mbL"><a href="/categoryAll/" class="btnType03">すべての記事</a></p>
</div>

<?php the_field('sideinfo', 327, false); ?>
</div>
   
<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>

<?php include("footer.php");?>