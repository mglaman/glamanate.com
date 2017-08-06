<header class="l-header">
  <nav class="l-navigation" role="navigation">
    <div class="l-constrained">
      <?php print theme('links__system_main_menu', array(
          'links' => $main_menu,
          'attributes' => array(
            'id' => 'primary',
            'class' => array('links', 'clearfix'),
          ),
          'heading' => array(
            'text' => t('Main menu'),
            'level' => 'h2',
            'class' => array('element-invisible'),
          ),
        )); ?>
    </div>
  </nav>
  <div class="l-branding">
    <div itemscope itemtype="http://schema.org/Organization">
      <?php if ($site_name): ?>
        <h1 id="site-name" class="site__name" itemprop="brand"><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a></h1>
      <?php endif; ?>

      <?php if ($site_slogan): ?>
        <p class="site__slogan">Drupal developer, contributor; groovin' on Drupal Commerce and Panopoly.</p>
      <?php endif; ?>
    </div>
  </div>
</header>
<section class="l-constrained">
  <main class="l-main" role="main">
    <div class="l-inner-padding">
      <?php print render($title_prefix); ?>
      <?php /* if ($title): ?><h1 class="page-title"><?php print $title; ?></h1><?php endif; */ ?>
      <?php print render($title_suffix); ?>

      <?php print $messages; ?>
      <?php print render($page['help']); ?>

      <?php if ($tabs): print render($tabs); endif; ?>

      <?php if ($action_links): ?><ul><?php print render($action_links); ?></ul><?php endif; ?>

      <?php print render($page['content']) ?>
    </div>
  </main>
  <div class="l-sidebar">
    <aside class="l-card">
      <div class="gravatar">
        <img src="https://s.gravatar.com/avatar/6f1c544038110c03167685afa17993eb.png?s=180" alt="Gravatar of Matt Glaman" />
      </div>
      <div class="card__social-links">
        <?php print render($page['social_links']); ?>
      </div>

      <div class="block--site-search">
        <?php print render($page['exposed_search_block']); ?>
      </div>
    </aside>
    <?php if ($page['sidebar_share']): ?>
      <aside class="social-sharing l-card">
        <h3>SHARE THIS</h3>
        <?php print render($page['sidebar_share']); ?>
      </aside>
    <?php endif; ?>
    <aside class="l-card" style="text-align: center">
      <h3 class="block__title">Drupal 8 Development Cookbook</h3>
      <a href="/blog/drupal-8-development-cookbook">
        <img src="https://glamanate.com/sites/default/files/styles/large/public/B05206_MockupCover_Cookbook%20%281%29.jpg?itok=aV4ILzAC" alt="Drupal 8 Development Cookbook" />
      </a>
    </aside>
    <?php if ($page['sidebar_ad']): ?>
      <aside class="l-card" style="text-align: center">
        <?php print render($page['sidebar_ad']); ?>
      </aside>
    <?php endif; ?>
    <?php if ($page['tag_cloud']): ?>
      <aside class="l-card">
        <?php print render($page['tag_cloud']); ?>
      </aside>
    <?php endif; ?>
    <aside class="bitcoin-tip l-card">
      <h3 class="block__title">tip via bitcoin</h3>
      <div class="bitcoin-tip--qr">
        <a href="bitcoin:1B5UR2Wn1cE6S31FenqAqoXJY4pBaweJtQ">
          <img src="/sites/all/themes/mglaman/images/bitcoin-qr.png" alt="1B5UR2Wn1cE6S31FenqAqoXJY4pBaweJtQ"/>
        </a>
      </div>
      <div class="bitcoin-tip--address">
        <a href="bitcoin:1B5UR2Wn1cE6S31FenqAqoXJY4pBaweJtQ">1B5UR2Wn1cE6S31FenqAqoXJY4pBaweJtQ</a></pre>
      </div>
    </aside>
  </div>
</section>

<footer class="l-footer">
  <div class="l-footer-inner l-constrained">
    <?php print render($page['disqus']); ?>
    <?php print render($page['footer']); ?>
  </div>
  <div class="l-footer-bottom">
    <div class="l-constrained">
      <p class="code__is__poetry">&lt;? CODE IS POETRY ?&gt;</p>
    </div>
  </div>
</footer>
