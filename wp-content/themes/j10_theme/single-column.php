<?php
/********************
Column
*********************/
include("header.php");
?>

<?php $text_field = get_field('text_field'); ?>

<div id="contentsWrap">
<div class="contents pb0">
   <ul class="topicPath pl0">
    <li><a href="/">TOP</a></li>
    <li><a href="/column/">富士山の天然水とのくらし</a></li>
    <li><?php the_title(); ?></li>
  </ul>
  <div class="pcCellWrap">
  <div class="pcCellWrap__main">
   <div class="columnEntry">
        <div class="columnEntry__header">
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
          <h1 class="columnEntry__header__title"><?php the_title(); ?></h1>
          <p class="columnList__items__date"><?php echo get_the_date( 'Y.m.d' ); ?></p>
        </div>
        <div class="columnEntry__body">
          <p class="entryThumb"><?php the_post_thumbnail('post-thumbnail', array('class' => 'imgWmax')); ?></p>
          
           <div class="indexList">
            <p class="indexList__title">目次</p>
            <ol class="numList01">
            </ol>
          </div>
           
           <?php
             while ( have_posts() ) : the_post();
             the_content();
             endwhile;
            ?>
          <?php if(post_custom('btnhide')): ?>
          
          <?php else : ?>
			<p class="btn"><a href="<?php the_field('url'); ?>" class="btnType01 layoutC">ウォーターサーバについて詳細はこちら</a></p>
			<?php endif; ?>
          
        </div>
        <div class="columnEntry__footer">
          <!--<h2 class="deviceTtl02">この記事をシェアする</h2>
          <ul class="columnEntry__footer__shareList">
            <li><a href="#"><img src="http://placehold.jp/24/D9D9D9/fff/80x80.png?text=?"></a></li>
            <li><a href="#"><img src="http://placehold.jp/24/D9D9D9/fff/80x80.png?text=?"></a></li>
            <li><a href="#"><img src="http://placehold.jp/24/D9D9D9/fff/80x80.png?text=?"></a></li>
            <li><a href="#"><img src="http://placehold.jp/24/D9D9D9/fff/80x80.png?text=?"></a></li>
          </ul>-->
<?php
  $prev_post = get_previous_post(); // 前の投稿を取得
  $next_post = get_next_post(); // 次の投稿を取得
?>
            <ul class="columnEntry__footer__pager">
              <?php if (get_previous_post()):?>
               <li class="back"><a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>">前の記事へ</a></li>
               <?php endif; ?>
               <li><a href="/column/">コラム一覧へ</a></li>
               <?php if (get_next_post()):?>
               <li class="next"><a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>">次の記事へ</a></li>
               <?php endif; ?>   
            </ul>

        </div>
      </div>
  </div>
     
  <?php the_field('sideinfo', 327, false); ?>
  
  </div>
<h2 class="deviceTtl02">新着記事</h2>
  <div class="columnList">
    <ul>
       <?php
$paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $mypost = array(
		'posts_per_page'   => 3,
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
<?php wp_reset_query(); ?>
<?php endif; ?>
</ul>
  </div>

  <h2 class="deviceTtl02 mtL">関連記事</h2>
  <div class="columnList">
       <?php
$post_id = get_the_ID(); // 投稿のIDを取得
$categories = get_the_category($post_id); // 投稿のカテゴリーを取得
$cat_ids = []; // カテゴリーIDを格納するための空の配列を用意

foreach ($categories as $category) :
  array_push($cat_ids, $category->term_id); // 用意した空配列にカテゴリーIDを格納
endforeach;

$args = [
  'post_type' => 'column', // 投稿タイプを指定
  'posts_per_page' => '3', // 表示する記事数を指定
  'category__in' => $cat_ids, // カテゴリーIDを指定
  'post__not_in' => [$post_id] // 現在の投稿を除外
];

$related_cats_query = new WP_Query($args);
?>

<div class="related-posts">
  <?php if ($related_cats_query->have_posts()) : ?>
   
    <ul>
      <?php while ($related_cats_query->have_posts()) : $related_cats_query->the_post(); ?>
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
      <?php endwhile; ?>
</div>
</ul>
  <?php else : ?>
    
  <?php
  endif;
  wp_reset_postdata(); ?>

  </div>
  
  <div class="wideSection">
    <div class="pcW800">
    <h2 class="deviceTtl02"><span class="enTitle">Company</span>会社概要</h2>
    <table class="dataTable01 dataTable01--thM2 LINE--GB1 mt30">
      <tr>
        <th>会社名</th>
        <td>株式会社富士山の天然水</td>
      </tr>
      <tr>
        <th>代表取締役</th>
        <td>村田憲司</td>
      </tr>
      <tr>
        <th>オフィス住所</th>
        <td> <a href="https://www.google.com/maps/place/%E3%80%92170-0013+%E6%9D%B1%E4%BA%AC%E9%83%BD%E8%B1%8A%E5%B3%B6%E5%8C%BA%E6%9D%B1%E6%B1%A0%E8%A2%8B%EF%BC%91%E4%B8%81%E7%9B%AE%EF%BC%92%E2%88%92%EF%BC%98+%E3%81%A4%E3%81%8B%E3%81%93%E3%81%97%E3%83%93%E3%83%AB+8f/@35.7301559,139.7139177,17z/data=!3m1!4b1!4m5!3m4!1s0x60188d67cb87fc55:0x99b2e725f2e47a36!8m2!3d35.7301559!4d139.7139177" class="iconMap" target="_blank">東京都豊島区東池袋1-2-8<br class="spOnly">つかこしビル8F</a></td>
      </tr>
      <tr>
        <th>電話番号</th>
        <td><a href="tel:+03-5911-6969">03-5911-6969</a></td>
      </tr>
      <tr>
        <th>メールアドレス</th>
        <td><a href="mailto:info123@mt-fuji-nmw.com">info123@mt-fuji-nmw.com</a></td>
      </tr>
      <tr>
        <th>URL</th>
        <td><a href="https://mt-fuji-nmw.com/">https://mt-fuji-nmw.com/</a></td>
      </tr>
      <tr>
        <th>営業時間</th>
        <td>9:00～17:00　(土日祝日除く)</td>
      </tr>
      <tr>
    </table>
  </div>
  </div>
   
<!--.contents--></div>
<!--.contentsWrap--></div>

<?php get_sidebar(); ?>

<?php include("footer.php");?>