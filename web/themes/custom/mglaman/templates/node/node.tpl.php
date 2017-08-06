<article id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?>"<?php print $attributes; ?>>
  <?php if (!$page || $display_submitted): ?>
  <header>
    <?php if (!$page): ?>
      <h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
    <?php else: ?>
      <h1 class="node__title"><?php print $title; ?></h1>
    <?php endif; ?>

    <?php if ($display_submitted): ?><span class="node__submitted">On <?php print $date; ?></span><?php endif; ?>
  </header>
  <?php endif; ?>
  <?php
    // We hide the comments and links now so that we can render them later.
    hide($content['comments']);
    hide($content['links']);
    print render($content);
  ?>

  <footer>
    <div class="node__meta">
      <?php if (!empty($content['links']['terms'])): ?>
        <?php print render($content['links']['terms']); ?>
      <?php endif;?>
    </div>
    <div class="node__links">
      <?php if (!empty($content['links'])): ?>
        <?php print render($content['links']); ?>
      <?php endif; ?>
    </div>
  </footer>
</article> <!-- /node-->
