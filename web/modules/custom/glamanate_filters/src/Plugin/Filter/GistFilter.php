<?php

namespace Drupal\glamanate_filters\Plugin\Filter;

use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;


/**
 * Provides a filter to align elements.
 *
 * @Filter(
 *   id = "gist_filter",
 *   title = @Translation("Gist filter"),
 *   description = @Translation("Embeds Github Gists."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_TRANSFORM_REVERSIBLE
 * )
 */
class GistFilter extends FilterBase {
  public function process($text, $langcode) {
    $text = preg_replace_callback('@\[gist\:(?<id>[\w/]+)(?:\:(?<file>[\w\.]+))?\]@', [$this, 'gistDisplayEmbed'], $text);
    return new FilterProcessResult($text);
  }

  public function tips($long = FALSE) {
    $output = $this->t('Use <code>[gist:#####]</code> where <code>#####</code> is your gist number to embed the gist') . '<br />';
    $output.= $this->t('You may also include a specific file within a multi-file gist with <code>[gist:####:my_file]</code>.');
    return $output;
  }


  /**
   * Replace the text with embedded script.
   */
  protected function gistDisplayEmbed(array $matches) {
    $gist_url_base = '//gist.github.com/' . $matches['id'];
    $gist_url = isset($matches['file']) && !empty($matches['file'])
      ? $gist_url_base . '.js?file=' . $matches['file']
      : $gist_url_base . '.js';

    // Also grab the content and display it in code tags (in case the user does not have JS).
    $output = "<noscript>View GitHub Gist $gist_url_base</noscript>";
    $output .= '<script src="' . $gist_url . '"></script>';
    return $output;
  }
}
