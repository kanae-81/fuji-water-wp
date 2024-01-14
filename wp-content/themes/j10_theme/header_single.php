<!DOCTYPE html>
<html lang="ja">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php bloginfo('name');?></title>
<?php if( get_field('description')): ?><meta name="description" content="<?php the_field('description'); ?>"><?php else: ?><meta name="description" content="<?php the_field('sitedescription', 39); ?>"><?php endif; ?>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="format-detection" content="telephone=no">
<meta name="robots" content="index, follow">
<!-- meta-og -->
<meta property="og:type" content="website">
<meta property="og:title" content="<?php bloginfo('name');?>">
<?php if( get_field('description')): ?><meta property="og:description" content="<?php the_field('description'); ?>"><?php elseif ( is_home() || is_front_page() ) : ?><meta property="og:description" content="トップに入る内容が入ります。"><?php else : ?><meta property="og:description" content="<?php the_field('sitedescription', 39); ?>"><?php endif; ?>

<meta property="og:url" content="<?php echo get_the_permalink(); ?>">
<meta property="og:image" content="<?php if (empty($_SERVER["HTTPS"])) {
  echo "http://";
} else {
  echo "https://";
}
echo $_SERVER["HTTP_HOST"]; ?><?php the_field('ogimage', 39); ?>">

<meta property="og:site_name" content="株式会社富士山の天然水">
<meta property="og:locale" content="ja_JP">
<!--meta-og -->
<link rel="canonical" href="https://www.jxrits.com/">
<link rel="shortcut icon" href="/favicon.ico">
<link rel="apple-touch-icon-precomposed" href="/common/images/webclip.png">

<link rel="stylesheet" type="text/css" href="/common/css/reset.css">
<link rel="stylesheet" type="text/css" href="/common/css/layout.css">
<link rel="stylesheet" type="text/css" href="/common/css/module.css">

<script>
  (function(d) {
    var config = {
      kitId: 'itr0uja',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>
   
<?php the_field('analytics', 38); ?>

<?php if( is_user_logged_in() ) : ?>
<style type="text/css">
@media screen and ( max-width: 782px ) {
		html { margin-top: 0 !important; }
		* html body { margin-top: 0 !important; }
	}
</style>
<?php endif; ?>	
</head>

<body>
<div id="wrap">
<header class="spOnly">
<div class="headerInner">
<p class="SPmenu">メニュー</p>
</div>
<div class="menuBox">
  <p class="SPclose">閉じる</p>
  <p class="logo"><a href="/"><strong>富士山</strong>の<br><strong>天然水</strong></a></p>
  <ul>
    <li><a href="/natural_mineral_water/">富士山の天然水とは</a></li>
    <li><a href="/water_server/">ウォーターサーバー</a></li>
    <li><a href="/bottle/#">オリジナルペットボトル</a></li>
    <li><a href="/column/">富士山の天然水と暮らす</a></li>
    <li><a href="/company/">会社紹介</a></li>
    <li><a href="/contact/">お問い合わせ</a></li>
  </ul>
</div>
</header>

<header class="pcOnly">
<div class="headerInner">
<p class="logo"><a href="/">富士山<span>の</span>天然水</a></p>
<ul>
  <li><a href="/natural_mineral_water/">富士山の天然水とは</a></li>
  <li><a href="/water_server/">ウォーターサーバー</a></li>
  <li><a href="/bottle/#">オリジナルペットボトル</a></li>
  <li><a href="/column/">富士山の天然水と暮らす</a></li>
  <li><a href="/company/">会社紹介</a></li>
</ul>
<p class="contact"><a href="/contact/">お問い合わせ</a></p>
</div>
</header>
