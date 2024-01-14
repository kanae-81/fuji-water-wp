<?php
/*
Template Name: コラム一覧
*/
include("header.php");
?>

<div class="titleBlock titleBlock--L">
  <ul class="topicPath">
    <li><a href="/">TOP</a></li>
    <li>富士山の天然水とのくらし</li>
  </ul>
  <p class="enTitle">Point of the Water</p>
  <h1>富士山の天然水とのくらし</h1>
</div>

<div id="contentsWrap">
<div class="contents">
<div class="pcCellWrap">
<div class="pcCellWrap__main">
<h2 class="deviceTtl02">新着記事</h2>
<div class="columnList columnList--sp2pc3 columnList--pc1stL">
<ul class="columnWidth">
<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $mypost = array(
		'posts_per_page'   => 10,
		'orderby'          => 'date',
		'order'            => 'DESC',
		'post_type'        => 'column',
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
  $pages = $the_query->max_num_pages;
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
   
<?php /*?><!--<h2 class="deviceTtl02 LINE--GT1L">カテゴリ</h2>
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
</div>--><?php */?>

<p class="btnType02Wrap mbL"><a href="/categoryAll/" class="btnType03">すべての記事</a></p>
</div>

<?php the_field('sideinfo', 327, false); ?>
</div>
   
<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>

<?php include("footer.php");?>