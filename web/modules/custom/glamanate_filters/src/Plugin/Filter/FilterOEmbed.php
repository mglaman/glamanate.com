<?php

namespace Drupal\glamanate_filters\Plugin\Filter;

use Alb\OEmbed\Simple;
use Drupal\Component\Utility\Html;
use Drupal\filter\FilterProcessResult;
use Drupal\filter\Plugin\FilterBase;

/**
 * Provides a fallback placeholder filter to use for missing filters.
 *
 * The filter system uses this filter to replace missing filters (for example,
 * if a filter module has been disabled) that are still part of defined text
 * formats. It returns an empty string.
 *
 * @Filter(
 *   id = "oembed",
 *   title = @Translation("oEmbed filter"),
 *   description = @Translation("Embeds content for oEmbed-enabled web addresses and turns the rest, and e-mail addresses, into clickable links."),
 *   type = Drupal\filter\Plugin\FilterInterface::TYPE_MARKUP_LANGUAGE,
 *   settings = {
 *     "options" = "",
 *     "autoembed" = true
 *   },
 *   weight = -10
 * )
 */
class FilterOEmbed extends FilterBase {

  const OEMBED_PATTERN_AUTOEMBED = '|^\s*(https?://[^\s"]+)\s*$|im';
  const OEMBED_PATTERN_EMBED_SHORTCODE = '/(.?)\[embed\b(.*?)\](.+?)\[\/embed\](.?)/s';
  const OEMBED_PATTERN_EMBED_UNWRAP = '/<p>\s*+(\[embed\b.*?\].+?\[\/embed\])\s*+<\/p>/s';

  public function prepare($text, $langcode) {
    $text = preg_replace_callback(self::OEMBED_PATTERN_AUTOEMBED, [$this, 'oembed_preg_auto_replace'], $text);
    return $text;
  }

  /**
   * Performs the filter processing.
   *
   * @param string $text
   *   The text string to be filtered.
   * @param string $langcode
   *   The language code of the text to be filtered.
   *
   * @return \Drupal\filter\FilterProcessResult
   *   The filtered text, wrapped in a FilterProcessResult object, and possibly
   *   with associated assets, cacheability metadata and placeholders.
   *
   * @see \Drupal\filter\FilterProcessResult
   */
  public function process($text, $langcode) {

    // Undo auto paragraph around oEmbed shortcodes.
    $text = preg_replace(self::OEMBED_PATTERN_EMBED_UNWRAP, '$1', $text);

    $text = preg_replace_callback(self::OEMBED_PATTERN_EMBED_SHORTCODE, array($this, 'oembed_preg_tag_replace'), $text);

    return new FilterProcessResult($text);
  }

  public function tips($long = FALSE)
  {
    if ($long) {
      return t('Embed content by wrapping a supported URL in [embed] &hellip; [/embed]. Set options such as width and height with attributes [embed width="123" height="456"] &hellip; [/embed]. Unsupported options will be ignored.');
    }
    else {
      return t('Embed content by wrapping a supported URL in [embed] &hellip; [/embed].');
    }
  }

  /**
   * PREG replace callback finds [embed] shortcodes, URLs and request options.
   * @param $match
   * @return string
   */
  private function oembed_preg_tag_replace($match) {

    // allow [[oembed]] syntax for escaping a tag
    if ($match[1] == '[' && $match[4] == ']') {
      return substr($match[0], 1, -1);
    }

    $url = $match[3];

    $shortcode_options = !empty($match[2]) ? self::oembed_parse_attr($match[2]) : array();
    $options = !empty($this->settings['options']) ? self::oembed_parse_attr($this->settings['options']) : array();

    $options = array_merge($options, $shortcode_options);

    return $match[1] . $this->oembed_resolve_link($url, $options) . $match[4];
  }

  /**
   * Retrieve all attributes from the shortcodes tag.
   *
   * @see shortcode_parse_atts in WordPress 3.1.3.
   * @param string $text
   * @return array List of attributes and their value.
   */
  private static function oembed_parse_attr($text) {
    $attributes = array();
    $pattern = '/([\w-]+)\s*=\s*"([^"]*)"(?:\s|$)|([\w-]+)\s*=\s*\'([^\']*)\'(?:\s|$)|([\w-]+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
    $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
    if (preg_match_all($pattern, $text, $matches, PREG_SET_ORDER)) {
      foreach ($matches as $match) {
        if (!empty($match[1])) {
          $attributes[strtolower($match[1])] = stripcslashes($match[2]);
        }
        elseif (!empty($match[3])) {
          $attributes[strtolower($match[3])] = stripcslashes($match[4]);
        }
        elseif (!empty($match[5])) {
          $attributes[strtolower($match[5])] = stripcslashes($match[6]);
        }
        elseif (isset($match[7]) && strlen($match[7])) {
          $attributes[] = stripcslashes($match[7]);
        }
        elseif (isset($match[8])) {
          $attributes[] = stripcslashes($match[8]);
        }
      }

      // Reject any unclosed HTML elements
      foreach( $attributes as &$value ) {
        if ( false !== strpos( $value, '<' ) ) {
          if ( 1 !== preg_match( '/^[^<]*+(?:<[^>]*+>[^<]*+)*+$/', $value ) ) {
            $value = '';
          }
        }
      }
    } else {
      $attributes = ltrim($text);
    }
    return $attributes;
  }

  /**
   * PREG replace callback finds [embed] shortcodes, URLs and request options.
   *
   * Override in Drupal system variable `oembed_resolve_link_callback`
   *
   * @see MediaInternetOEmbedHandler::preSave().
   *
   * @param string $url
   *   URL to embed.
   * @param array $options
   *   oEmbed request options.
   *
   * @return string
   *   Rendered oEmbed response.
   */
  private function oembed_resolve_link($url, $options = array()) {

    $url = Html::decodeEntities($url);

    $embed = Simple::request($url, $options);

    $return = $embed->getHtml();

    if (empty($return)) {
      $return = $url;
    }

    return new FilterProcessResult($return);
  }

  /**
   * PREG replace callback finds URLs
   * @param $match
   * @return string
   */
  private static function oembed_preg_auto_replace($match) {
    return '[embed]'. $match[1] ."[/embed]\n";
  }
}
