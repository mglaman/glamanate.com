<?php

namespace Drupal\glamanate_filters\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;


/**
 * Provides a filter to align elements.
 *
 * @Filter(
 *   id = "twitter_links",
 *   title = @Translation("Twitter links"),
 *   description = @Translation("Does nothing."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class TwitterLinks extends FilterBase {
  public function process($text, $langcode) {
    return new FilterProcessResult($text);
  }

}
