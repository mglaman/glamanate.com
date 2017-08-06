<?php

namespace Drupal\glamanate_filters\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\Plugin\Field\FieldFormatter\EntityReferenceEntityFormatter;

/**
 * Plugin implementation of the 'image' formatter.
 *
 * @FieldFormatter(
 *   id = "file_rendered",
 *   label = @Translation("File rendered"),
 *   field_types = {
 *     "entity_reference"
 *   }
 * )
 */
class FileRendered extends EntityReferenceEntityFormatter {

}
