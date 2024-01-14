<!DOCTYPE html>
<html lang="ja"><head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# article: http://ogp.me/ns/article#">
<!-- META// -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width,target-densitydpi=device-dpi,initial-scale=1.0,maximum-scale=1.0">
<meta name="format-detection" content="telephone=no,email=no">
<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE">
<?php if( get_field('description')): ?><meta name="description" content="<?php the_field('description'); ?>"><?php else: ?><meta name="description" content="<?php the_field('sitedescription', 39); ?>"><?php endif; ?>
   
<title><?php wp_title('|', true, 'right'); ?> <?php echo $title; ?> <?php bloginfo('name');?></title>
<!-- //META -->
<!-- OGP// -->
<meta property="og:type" content="website">
<meta property="og:url" content="<?php echo get_the_permalink(); ?>">
<meta property="og:image" content="<?php if (empty($_SERVER["HTTPS"])) {
  echo "http://";
} else {
  echo "https://";
}
echo $_SERVER["HTTP_HOST"]; ?><?php the_field('ogimage', 39); ?>">
<meta property="og:title" content="<?php wp_title('|', true, 'right'); ?> <?php echo $title; ?> <?php bloginfo('name');?>">
<?php if( get_field('description')): ?><meta property="og:description" content="<?php the_field('description'); ?>"><?php elseif ( is_home() || is_front_page() ) : ?><meta property="og:description" content="<?php the_field('description'); ?>"><?php else : ?><meta property="og:description" content="<?php the_field('sitedescription', 39); ?>"><?php endif; ?>

<!-- //OGP -->
<!-- LINK// -->
<link rel="shortcut icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="icon" href="/favicon.ico" type="image/vnd.microsoft.icon">
<link rel="apple-touch-icon" sizes="192x192" href="/apple-touch-icon192.png">
<!-- //LINK -->
<!-- CSS// -->
<link rel="stylesheet" type="text/css" href="/common/css/reset.css">
<link rel="stylesheet" type="text/css" href="/common/css/layout.css">
<link rel="stylesheet" type="text/css" href="/common/css/module.css">
<!-- //CSS -->
<?php wp_head(); ?>

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
#wpadminbar{ top:auto !important; bottom:0 !important;}
@media screen and ( max-width: 782px ) {
		html { margin-top: 0 !important; }
		* html body { margin-top: 0 !important; }
   #wpadminbar{ top:0 !important; bottom:auto !important;}
	}
</style>
<?php endif; ?>
   
<?php if(is_page('estimate') || is_parent_slug() === 'estimate'): ?>
<style type="text/css">
.mw_wp_form .horizontal-item + .horizontal-item{ margin-left: 0;}
.checkRadioList span.mwform-radio-field{position: relative; display: inline-block; padding-left: 40px;margin-right: 30px;}
.checkRadioList span label{display: inline-block;}
.checkRadioList span input[type=radio]{position: absolute; top: 0;left: 0; background: url(/common/img/icon_check_off_2.svg) no-repeat 0 0; background-size: cover; width: 26px; height: 26px; display: block;}
.checkRadioList span input[type=radio]:checked{background: url(/common/img/icon_check_on_2.svg) no-repeat 0 0; background-size: cover;}
</style>   
<?php endif; ?>
</head>

<?php if(is_page('company') || is_parent_slug() === 'company'): ?>
<body class="companyType">
<?php elseif(is_page('categoryall') || is_parent_slug() === 'categoryall'): ?>
<body class="companyType">
<?php elseif(is_archive('column') || is_singular('column')): ?>
<body class="companyType">
<?php elseif(is_page('bottle') || is_singular('bottle')): ?>
<body class="spBtnType2 WhiteType3">
<?php elseif(is_page('water_server') || is_singular('water_server')): ?>
<body class="spBtnType1 WhiteType2">
<?php elseif(is_page('natural_mineral_water') || is_parent_slug() ==='natural_mineral_water'): ?>
<body class="WhiteType">
<?php elseif ( is_home() || is_front_page() ) : ?>
<body class="WhiteType">
<?php else: ?>
<body>
<?php endif; ?>
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
    <li><a href="/bottle/">オリジナルペットボトル</a></li>
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
  <li><a href="/bottle/">オリジナルペットボトル</a></li>
  <li><a href="/column/">富士山の天然水と暮らす</a></li>
  <li><a href="/company/">会社紹介</a></li>
</ul>
<p class="contact"><a href="/contact/">お問い合わせ</a></p>
</div>
</header>
