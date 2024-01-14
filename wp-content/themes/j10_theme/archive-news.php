<?php
/*
Template Name: ニュース一覧
*/
include("header.php");
?>

<div class="titleBlock">
  <h1>ニュース一覧</h1>
</div>

<div id="contentsWrap">
<div class="contents">
<ul class="newsList">
<?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $mypost = array(
		'posts_per_page'   => 10,
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
<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>

<?php include("footer.php");?>