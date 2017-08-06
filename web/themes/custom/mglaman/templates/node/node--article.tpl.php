<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <div <?php print drupal_attributes($article_intro_attributes); ?>>
  </div>
  <div class="article--main l-card">
    <header>
      <?php if (!$page): ?>
        <span class="node__submitted">Published on <?php print $date; ?></span>
        <h2 class="node__title"><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
      <?php else: ?>
        <h1 class="node__title"><?php print $title; ?></h1>
        <span class="node__submitted">Published on <?php print $date; ?></span>
      <?php endif; ?>

      <?php print render($content['field_subtitle']); ?>
    </header>

    <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    hide($content['field_subtitle']);
    hide($content['field_images']);
    hide($content['field_featured_image']);
    print render($content);
    ?>

    <footer>
      <?php if ($page): ?>
        <div class="social-share--article">
          <h4>Share this article</h4>
          <?php print render($social_share); ?>
        </div>
        <div class="node__meta">
          <?php if (!empty($content['links']['terms'])): ?>
            <?php print render($content['links']['terms']); ?>
          <?php endif;?>
        </div>
      <?php endif; ?>
      <?php if (!empty($content['links'])): ?>
        <div class="node__links">
          <?php print render($content['links']); ?>
        </div>
      <?php endif; ?>
    </footer>
  </div>
  <?php if($page) : ?>
    <div class="google-ad">
      <style>
        .node-responsive { width: 320px; height: 50px; }
        @media(min-width: 500px) { .node-responsive { width: 468px; height: 60px; } }
        @media(min-width: 1100px) { .node-responsive { width: 728px; height: 90px; } }
      </style>
      <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
      <!-- Node Responsive -->
      <ins class="adsbygoogle node-responsive"
           style="display:inline-block"
           data-ad-client="ca-pub-1551015534754654"
           data-ad-slot="7144362751"></ins>
      <script>(adsbygoogle = window.adsbygoogle || []).push({});</script>
    </div>
  <?php endif; ?>
</article> <!-- /node-->
