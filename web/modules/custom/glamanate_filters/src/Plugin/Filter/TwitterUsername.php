<?php

namespace Drupal\glamanate_filters\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;


/**
 * Provides a filter to align elements.
 *
 * @Filter(
 *   id = "twitter_username",
 *   title = @Translation("Twitter username"),
 *   description = @Translation("Converts Twitter-style @usernames into links to Twitter account pages."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class TwitterUsername extends FilterBase {
  public function tips($long = FALSE) {
    return $this->t('Twitter-style @usernames are linked to their Twitter account pages.');
  }

  public function process($text, $langcode) {
    $match = '/(?<!\w)' . preg_quote('@', '/') . '(\w+)/ui';
    $replacement = '<a href="https://twitter.com/$1" class="twitter-atreply"">@$1</a>';
    $text = preg_replace($match, $replacement, $text);
    return new FilterProcessResult($text);
  }

}
