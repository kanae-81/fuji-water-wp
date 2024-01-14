<?php
add_theme_support( 'post-thumbnails' );
add_theme_support( 'title-tag' );

remove_action("wp_head", "wp_resource_hints", 2);
remove_action("wp_head", "feed_links_extra", 3);
remove_action("wp_head", "print_emoji_detection_script", 7);
remove_action("wp_print_styles", "print_emoji_styles");
remove_action("wp_head","rest_output_link_wp_head");
remove_action("wp_head", "rsd_link");
remove_action("wp_head", "wlwmanifest_link");
remove_action("wp_head", "adjacent_posts_rel_link_wp_head");
remove_action("wp_head", "wp_generator");
remove_action("wp_head", "rel_canonical");
remove_action("wp_head", "wp_shortlink_wp_head", 10, 0);
remove_action("wp_head", "wp_oembed_add_discovery_links");
remove_action("wp_head", "_wp_render_title_tag", 1);
function dequeue_plugins_style() {
    //プラグインIDを指定し解除する
    wp_dequeue_style('wp-block-library');
}
add_action( 'wp_enqueue_scripts', 'dequeue_plugins_style', 9999);

function change_title_separator( $sep ){
  $sep = ' | ';
  return $sep;
}
add_filter( 'document_title_separator', 'change_title_separator' );


add_filter( 'upload_mimes', function ( $mimes ) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

add_filter( 'manage_media_columns', function ( $columns ) {
    echo '<style>.media-icon img[src$=".svg"]{width:100%;}</style>';
    return $columns;
});

/*******************************************
タグの自動挿入を無効化
*******************************************/
add_action('init', function() {
    remove_filter('the_title', 'wptexturize');
    remove_filter('the_content', 'wptexturize');
    remove_filter('the_excerpt', 'wptexturize');
    remove_filter('the_title', 'wpautop');
    remove_filter('the_content', 'wpautop');
    remove_filter('the_excerpt', 'wpautop');
    remove_filter('the_editor_content', 'wp_richedit_pre');
});

/*******************************************
パンくずリスト
*******************************************/
function breadcrumb(){
  global $post;
  $str = '';
  $pNum = 2;
  $kaisou = 1;
  $str.= '<ul class="topicPath">';
  $str.= '<li><a href="/">TOP</li>';

  /* 通常の投稿ページ  */
  if(is_singular('post')){
    $categories = get_the_category($post->ID);
    $cat = $categories[0];

    if($cat->parent != 0){
      $ancestors = array_reverse(get_ancestors($cat->cat_ID, 'category'));
      foreach($ancestors as $ancestor){
        $str.= '<li><a href="'. get_category_link($ancestor).'">'.get_cat_name($ancestor).'</a></li>';
      }
    }
    $str.= '<li><a href="'. get_category_link($cat-> term_id). '">'.$cat->cat_name.'</a></li>';
    $str.= '<li>'.$post->post_title.'</li>';
  }

  /* カスタムポスト */
  elseif(is_single() && !is_singular('news')){
    $cp_name = get_post_type_object(get_post_type())->label;
    $cp_url = home_url('/').get_post_type_object(get_post_type())->name;
    $kaisou = $kaisou + 1;
    $str.= '<li><a href="'.$cp_url.'">'.$cp_name.'</a></li>';
    $str.= '<li><span>'.$post->post_title.'</span></li>';

  }

  /* 固定ページ */
  elseif(is_page()){
    $pNum = 2;
    if($post->post_parent != 0 ){
      $ancestors = array_reverse(get_post_ancestors($post->ID));
      foreach($ancestors as $ancestor){
        $kaisou = $kaisou + 1;
        $str.= '<li><a href="'. get_permalink($ancestor).'">'.get_the_title($ancestor).'</a></li>';
      }
    }
    $kaisou = $kaisou + 1;
    $str.= '<li>'. $post->post_title.'</li>';
  }

  /* カテゴリページ */
  elseif(is_category()) {
    $cat = get_queried_object();
    $pNum = 2;
    if($cat->parent != 0){
      $ancestors = array_reverse(get_ancestors($cat->cat_ID, 'category'));
      foreach($ancestors as $ancestor){
        $str.= '<li><a href="'. get_category_link($ancestor) .'">'.get_cat_name($ancestor).'</a></li>';
      }
    }
    $str.= '<li>'.$cat->name.'</li>';
  }

  /* タグページ */
  elseif(is_tag()){
    $str.= '<li>'. single_tag_title('', false). '</li>';
  }

  /* 時系列アーカイブページ */
  elseif(is_date()){
	$cp_name = get_post_type_object(get_post_type())->label;
    $cp_url = home_url('/').get_post_type_object(get_post_type())->name;  
	  
    if(get_query_var('day') != 0){
      $str.= '<li><a href="'.$cp_url.'">'.$cp_name.'</a></li>';
      $str.= '<li><a href="'. get_year_link(get_query_var('year')).'"><span>'.get_query_var('year').'年</span></a></li>';
      $str.= '<li><a href="'.get_month_link(get_query_var('year'), get_query_var('monthnum')).'"><span>'.get_query_var('monthnum').'月</span></a></li>';
      $str.= '<li><span>'.get_query_var('day'). '</span>日</li>';
    } elseif(get_query_var('monthnum') != 0){
	  $str.= '<li><a href="'.$cp_url.'">'.$cp_name.'</a></li>';
      $str.= '<li><a href="'. get_year_link(get_query_var('year')).'"><span>'.get_query_var('year').'年</span></a></li>';
      $str.= '<li><span>'.get_query_var('monthnum'). '</span>月</li>';
    } else {
       $kaisou = $kaisou + 1;
	  $str.= '<li><a href="'.$cp_url.'">'.$cp_name.'</a></li>';
      $str.= '<li><span>'.get_query_var('year').'年</span></li>';
    }
  }

  /* 投稿者ページ */
  elseif(is_author()){
    $str.= '<li><span>投稿者 : '.get_the_author_meta('display_name', get_query_var('author')).'</span></li>';
  }

  /* 添付ファイルページ */
  elseif(is_attachment()){
    $pNum = 2;
    if($post -> post_parent != 0 ){
      $str.= '<li><a href="'.get_permalink($post-> post_parent).'"><span>'.get_the_title($post->post_parent).'</span></a></li>';
    }
    $str.= '<li><span>'.$post->post_title.'</span></li>';
  }

  /* 検索結果ページ */
  elseif(is_search()){
    $str.= '<li><span>「'.get_search_query().'」で検索した結果</span></li>';
  }

  /* 404 Not Found ページ */
  elseif(is_404()){
    $str.= '<li><span>お探しの記事は見つかりませんでした。</span></li>';
  }

  /* その他のページ */
  else{
     $kaisou = $kaisou + 1;
    $str.= '<li><span>'.wp_title('', false).'</span></li>';
  }
  $str.= '</ul>';

  echo $str;
}


/*******************************************
Admin bar
*******************************************/
function my_admin_bar_bump_cb() {
	?>
<style type="text/css" media="screen">
	html { margin-top: 0 !important; }
	* html body { margin-top: 0 !important; }
	@media screen and ( max-width: 782px ) {
		html { margin-top: 0 !important; }
		* html body { margin-top: 0 !important; }
	}
</style>
	<?php
}

function my_admin_bar_init() {
	// remove_action( 'wp_head', '_admin_bar_bump_cb' );
	add_action( 'wp_head', 'my_admin_bar_bump_cb' );
}
add_action( 'admin_bar_init', 'my_admin_bar_init' );

/**
 * カスタム投稿タイプ「news」のアーカイブページの記事表示件数を変更する
 */
define('POSTS_PER_PAGE_NEWS', 10);
function change_posts_per_page($query)
{
    if ( is_admin() || ! $query->is_main_query() ) {
        return;
    }
    if ( $query->is_post_type_archive('news') ) {
        $query->set( 'posts_per_page', POSTS_PER_PAGE_NEWS );
    }
}
add_action( 'pre_get_posts', 'change_posts_per_page' );


//TinyMCE Advanced独自ボタン追加
//　ビジュアルエディタで任意クラスを付与
add_editor_style('editor-style.css');

function _my_tinymce($initArray) {
    $style_formats = array(
        array(
            'title' => '強調テキスト(黒)',
            'inline' => 'strong',
            'classes' => 'cB01'
        ),
        array(
            'title' => '強調テキスト(赤)',
            'inline' => 'strong',
            'classes' => 'cR01'
        ),
        array(
            'title' => '注釈テキスト',
            'inline' => 'span',
            'classes' => 'indent01'
        ),
        array(
         'title' => '囲みブロック',
         'block' => 'div',
         'classes' => 'bgBox01'
        ),
    );
    $initArray['style_formats'] = json_encode($style_formats);
    return $initArray;
}
add_filter('tiny_mce_before_init', '_my_tinymce', 10000);


//絶対パス→相対パス
function make_href_root_relative($input) {
    return preg_replace('!http(s)?://' . $_SERVER['SERVER_NAME'] . '/!', '/', $input);
}

//パーマリンク絶対パス→相対パス
function root_relative_permalinks($input) {
    return make_href_root_relative($input);
}
add_filter( 'the_permalink', 'root_relative_permalinks' );
add_filter( 'wp_get_attachment_url', 'root_relative_permalinks' );
	


/*******************************************
sitemap.xmlの更新
*******************************************/
function update_sitemap() {

	//トップページ 新着記事も更新されるので現在時刻にする
	$url = esc_url(home_url());
	$lastmod = date('Y-m-d\TH:i:s\Z');
	$xml = "<url><loc>{$url}</loc><lastmod>{$lastmod}</lastmod></url>";

	//固定ページと記事ページを取得
	$posts_array = get_posts(array(
			'post_type' => array("page", "post"),
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'noindex',
					'compare' => 'NOT EXISTS',
				)
			)
	));
	if($posts_array){
		foreach($posts_array as $post){
			setup_postdata($post);
			$url = get_the_permalink($post->ID);
			$lastmod = date('Y-m-d\TH:i:s\Z', get_post_timestamp($post, "modified"));
			$xml .= "<url><loc>{$url}</loc><lastmod>{$lastmod}</lastmod></url>";
		}
		wp_reset_postdata();
	}

	//カテゴリー
	/*$category_ids = get_terms("category", array("fields" => "ids"));
		foreach($category_ids as $category_id){
			$xml .= "<url><loc>".get_category_link($category_id)."</loc></url>";
	}*/
   $xml .= "<url><loc>https://jxrits.10pre.com/news_summary/</loc><lastmod>{$lastmod}</lastmod></url>";

	//最終的なxmlデータを整形
	$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?><urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" >{$xml}</urlset>";

	//ファイルを書き出し
	file_put_contents(get_theme_file_path("sitemap.xml"), $xml, LOCK_EX);
}
add_action('save_post', 'update_sitemap');

function is_parent_slug() {
	global $post;
	if ($post->post_parent) {
		$post_data = get_post($post->post_parent);
		return $post_data->post_name;
	}
}

/*【管理画面】投稿メニューを非表示 */
function remove_menus () {
  global $menu;
  remove_menu_page( 'edit.php' ); // 投稿を非表示
}
add_action('admin_menu', 'remove_menus');


add_action('parse_query', 'date_base_permalink');
function date_base_permalink($wp_query) {
  $q = (object)$wp_query->query_vars;

  // 年・月・日・時・分がURLに含まれていたら
if (!empty($q->year) && !empty($q->monthnum) && !empty($q->day)) {
    // シングルページを有効にして
    $wp_query->is_single = true;

    // アーカイブページを無効にする
    $wp_query->is_archive = false;
  }
}


remove_filter ('the_content', 'wpautop');
remove_filter ('acf_the_content', 'wpautop');

function mvwpform_autop_filter() {
  if ( class_exists( 'MW_WP_Form_Admin' ) ) {
    $mw_wp_form_admin = new MW_WP_Form_Admin();
    $forms = $mw_wp_form_admin->get_forms();
    foreach ( $forms as $form ) {
      add_filter( 'mwform_content_wpautop_mw-wp-form-' . $form->ID, '__return_false' );
    }
  }
}
mvwpform_autop_filter();

function mwform_form_class() {
  ?>
    <script>
      jQuery(function($) {
        $( '.mw_wp_form form' ).attr( 'class', 'contactForm' );
      });
    </script>
  <?php
}
add_action( 'wp_footer', 'mwform_form_class', 10000 );


// エラーメッセージの変更
function validation_rule($validation, $data, $Data) {
	$validation->set_rule('name', 'noempty', array('message' => 'ご氏名を入力してください'));
	$validation->set_rule('email', 'noempty', array('message' => 'メールアドレスを入力してください'));
  return $validation;
}
add_filter('mwform_validation_mw-wp-form-160', 'validation_rule', 10, 3);

// エラーメッセージの変更
function validation_rule2($validation, $data, $Data) {
	$validation->set_rule('name', 'noempty', array('message' => 'ご氏名を入力してください'));
	$validation->set_rule('email', 'noempty', array('message' => 'メールアドレスを入力してください'));
  return $validation;
}
add_filter('mwform_validation_mw-wp-form-168', 'validation_rule2', 10, 3);

