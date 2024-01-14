<?php
/**
 * footer
 */

?>

<footer>
<p class="pageTop"><a href="#wrap">トップへ</a></p>
<p class="footer_contact"><a href="/contact/">お問い合わせ</a></p>

<?php if(is_page('company') || is_parent_slug() === 'company'): ?>
<ul class="imgNav01">
  <li class="imgNav01__item1"><a href="/water_server/">
    <div class="imgNav01__text">ウォーターサーバーで<br>天然水を飲む</div>
    <div class="imgNav01__icon"><img src="/common/img/icon_badge_01.png" alt="優秀味覚賞受賞"></div>
  </a></li>
  <li class="imgNav01__item2"><a href="/bottle/">
    <div class="imgNav01__text">オリジナルペットボトルを作る</div>
  </a></li>
  <li class="imgNav01__item3"><a href="https://mtfujinmw.base.shop/" target="_blank">
    <div class="imgNav01__text">ペットボトルで<br>天然水を飲む</div>
  </a></li>
</ul>
<?php endif; ?>   
   
<?php if(is_page('contact') || is_parent_slug() === 'contact'): ?>
<ul class="imgNav01">
  <li class="imgNav01__item1"><a href="/water_server/">
    <div class="imgNav01__text">ウォーターサーバーで<br>天然水を飲む</div>
    <div class="imgNav01__icon"><img src="/common/img/icon_badge_01.png" alt="優秀味覚賞受賞"></div>
  </a></li>
  <li class="imgNav01__item2"><a href="/bottle/">
    <div class="imgNav01__text">オリジナルペットボトルを作る</div>
  </a></li>
  <li class="imgNav01__item3"><a href="https://mtfujinmw.base.shop/" target="_blank">
    <div class="imgNav01__text">ペットボトルで<br>天然水を飲む</div>
  </a></li>
</ul>
<?php endif; ?>
   
<div class="footerInner">
<div class="colR">
<ul class="main_nav">
  <li><a href="/water_server/">ウォーターサーバーで<br>天然水を飲む</a></li>
  <li><a href="/bottle/">オリジナルペットボトルを<br>つくる</a></li>
  <li><a href="https://mtfujinmw.base.shop/" target="_blank">ペットボトル<br>で天然水を飲む</a></li>
</ul></div>
<div class="colL">
<div class="logoWrap"><p class="logo"><a href="/"><strong>富士山</strong>の<br><strong>天然水</strong></a></p></div>
<ul class="sub_nav">
  <li><a href="/privacy_policy/">プライバシーポリシー</a></li>
  <li><a href="/law_info/">特定商取引法</a></li>
</ul>
<ul class="sub_nav">
  <li><a href="/customer_term/">利用規約</a></li>
  <li><a href="/point_term/">ポイント利用規約</a></li>
</ul>
</div>
</div>
</footer>
<!--#wrap--></div>
<!-- SCRIPT// -->
<script type="text/javascript" src="/common/js/jquery.min.js"></script>
<!--[if lt IE 9]><script src="/common/js/plugin/html5shiv-printshiv.js"></script><![endif]-->
<script type="text/javascript" src="/common/js/default.js"></script>
<!-- //SCRIPT -->

<?php if(is_page('contact') || is_parent_slug() === 'contact'): ?>
<script>
jQuery(function($) {
  if($('.error').length == 0){
		$('.errorBox').remove();
  }

  if(!$('div').hasClass('mw_wp_form_complete')){
      $('.columnView').remove();
  } else {
     $('.contactWrap').remove();
     $('.contactTtlWrap').remove();
     $('.mw_wp_form_complete').addClass('layoutC');
  }
});
</script>
<?php endif; ?>

<?php if(is_page('estimate') || is_parent_slug() === 'estimate'): ?>
<script>
jQuery(function($) {
  if($('.error').length == 0){
		$('.errorBox').remove();
  }
   
  if($('div').hasClass('mw_wp_form_confirm')){
      $('.confirmHide').remove();
  }

  if(!$('div').hasClass('mw_wp_form_complete')){
      $('.columnView').remove();
  } else {
     $('.contactWrap').remove();
     $('.contactTtlWrap').remove();
     $('.mw_wp_form_complete').addClass('layoutC');
  }
});
</script>
<?php endif; ?>

<?php wp_footer(); ?>

</body>
</html>