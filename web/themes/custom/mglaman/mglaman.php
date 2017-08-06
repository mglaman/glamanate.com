<?php

/**
 * Implements hook_preprocess_page().
 */
function mglaman_preprocess_page(&$variables) {
  // You can use preprocess hooks to modify the variables before they are passed
  // to the theme function or template file.
  $variables['page']['exposed_search_block'] = mglaman_exposed_search_block();
  $variables['page']['tag_cloud'] = mglaman_tag_cloud_block();
  $variables['page']['social_links'] = mglaman_social_links();
  $variables['page']['disqus'] = mglaman_disqus();

  $stop = null;
  $variables['page']['sidebar_ad'] = array();
  $variables['page']['sidebar_share'] = array();
  if (isset($variables['node'])) {
    if ($variables['node']->type == 'article') {
      $variables['page']['sidebar_share'] = mglaman_social_share($variables['node']);
    }
    $variables['page']['sidebar_ad'] = array('#markup' =>'<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Medium Rect Sidebar -->
<ins class="adsbygoogle"
     style="display:inline-block;width:300px;height:250px"
     data-ad-client="ca-pub-1551015534754654"
     data-ad-slot="6864563559"></ins>
<script>
(adsbygoogle = window.adsbygoogle || []).push({});
</script>');
  }
}

function mglaman_preprocess_node(&$variables) {
  if ($variables['type'] == 'article') {
    $is_page = $variables['page'];

    $article_intro_attributes = array(
      'class' => array(
        'article--intro',
      ),
    );
    if (!empty($variables['field_featured_image'])) {
      $variables['classes_array'][] = 'node-article--featured-image';
      $article_intro_attributes['style'] = array(
        'background-image: url(' . file_create_url($variables['field_featured_image'][0]['uri']) . ');',
         (!$is_page) ? 'height: 95px;' : 'height: ' . ($variables['field_featured_image'][0]['height'] - ($variables['field_featured_image'][0]['height'] * 0.1)) . 'px;',
      );
    }

    $variables['article_intro_attributes'] = $article_intro_attributes;

    if ($is_page) {
      $stop = null;
      $variables['content']['links']['node']['#links']['back_to_top'] = array(
        'title' => t('!up Back to top', array('!up' => '&uarr;')),
        'href' => 'node/' . $variables['nid'],
        'fragment' => 'node-' . $variables['nid'],
        'html' => true,
      );
      $variables['social_share'] = mglaman_social_share($variables['#node']);
    }
  }
  else {
    $variables['classes_array'][] = 'l-card';
  }
}

/**
 * Implements hook_form_alter().
 */
function mglaman_form_alter(&$form, &$form_state, $form_id) {
  if ('views_exposed_form' == $form_id) {
    if($form['submit']['#id'] == 'edit-submit-search') {
      $form['search_api_views_fulltext']['#attributes'] = array('placeholder' => array(t('Search')));
    }
  }
}

/**
 * Helper function for loading exposed filter form for search View
 */
function mglaman_exposed_search_block() {
  if(module_exists('views')) {
    $block = block_load('views', '-exp-search-page');
    $block_render = module_invoke('views', 'block_view', '-exp-search-page');
    return $block_render;
  }
}

function mglaman_tag_cloud_block() {
  if(module_exists('views')) {
    $block_render = module_invoke('views', 'block_view', 'tag_cloud-block');
    // $block_render['#subject'] = $block_render['subject'];
    // $block_render['#markup'] = $block_render['content']['#markup'];
    return $block_render['content'];
  }
}

function mglaman_disqus() {
  $node = menu_get_object();
  if (is_object($node)) {
    return module_invoke('disqus', 'block_view', 'disqus_comments');
  }
}

function mglaman_social_links() {
  $social_links = array(
    'twitter' => array(
      'title' => t('Twitter'),
      'href' => 'https://twitter.com/nmdmatt'
    ),
    'linkedin' => array(
      'title' => t('LinkedIn'),
      'href' => 'http://www.linkedin.com/in/mattglaman',
    ),
    'github' => array(
      'title' => t('GitHub'),
      'href' => 'https://github.com/mglaman',
    ),
    'drupal' => array(
      'title' => t('Drupal'),
      'href' => 'http://drupal.org/u/mglaman',
    ),
  );

  $menu_output = array();
  $menu_output['#sorted'] = TRUE;
  $menu_output['#theme_wrappers'][] = 'menu_tree';

  foreach ($social_links as $key => $item) {
    // Create render array for the menu link.
    $element = array();
    $element['#theme'] = 'menu_link';
    $element['#attributes']['class'] = array(
      'social--links',
    );
    $element['#network'] = $key;
    $element['#title'] = '<i class="fa fa-' . $key . '">&nbsp;</i><span class="helper-text">' .$item['title'] . '</span>';
    $element['#href'] = $item['href'];
    $element['#localized_options']  = array('html' => TRUE, 'external' => true, 'target' => '_blank', 'absolute' => true);

    // Add the menu_link item into the render array for the menu_tree.
    $menu_output[$key] = $element;
  }

  return $menu_output;
}

function mglaman_social_share($node) {
  return array(
    '#theme' => 'links',
    '#heading' => '',
    '#attributes' => array(
      'class' => array('social-sharing__list')
    ),
    '#links' => array(
      'social-sharing__link social-sharing__link--twitter' => array(
        'title' => '<i class="fa fa-twitter">&nbsp;</i><span>Twitter</span>',
        'href' => 'https://twitter.com/home',
        'html' => true,
        'query' => array(
          'status' => t('@title by @nmdmatt - @url', array(
            '@title' => $node->title,
            '@url' => url(current_path(), array('absolute' => true)),
          ))
        ),
      ),
      'social-sharing__link social-sharing__link--linkedin' => array(
        'title' => '<i class="fa fa-linkedin">&nbsp;</i><span>LinkedIn</span>',
        'href' => 'http://www.linkedin.com/shareArticle',
        'html' => true,
        'query' => array(
          'mini' => 'true',
          'url' => url(current_path(), array('absolute' => true)),
          'title' => $node->title,
          'summary' => $node->title,
        ),
      ),
      'social-sharing__link social-sharing__link--google' => array(
        'title' => '<i class="fa fa-google-plus">&nbsp;</i><span>Google+</span>',
        'href' => 'https://plus.google.com/share',
        'html' => true,
        'query' => array(
          'url' => url(current_path(), array('absolute' => true)),
        ),
      ),
    ),

  );
}
