<?php

namespace Hibp\Models;

use Hibp\Util;

/**
 * Base Class representing a Hibp model
 *
 * @package Hibp
 * @subpackage Models
 */

abstract class Model {

  /**
   * Construct this object
   *
   * @param \stdClass $data Raw data object
   */
  public function __construct(\stdClass $data) {
    $this->_convertToModel($data);
  }


  /**
   * Parse the stdClass object into a model
   *
   * @param \stdClass $raw_data
   */
  protected function _convertToModel(\stdClass $raw_data) {
    foreach ($raw_data as $key => $val) {
      $key_name = Util::toLowerCamelCase($key);
      if (property_exists($this, $key_name)) {
        $this->{$key_name} = $val;
      }
    }
  }
}
