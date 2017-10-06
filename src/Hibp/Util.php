<?php

namespace Hibp;

/**
 * Util helper class
 *
 * @package Hibp
 */
class Util {

  /**
   * Convert string to lowerCameCase
   * @param string $input
   * @return string
   */
  static public function toLowerCamelCase(string $input) : string {
    $input = preg_replace('~([A-Z])([A-Z])~', "\$1 \$2", $input);
    $input = preg_replace('~([a-z0-9])([A-Z])~', "\$1 \$2", $input);
    $input = strtolower(trim($input));
    return lcfirst(str_replace(' ', '', ucwords(preg_replace(
      '/[^a-z0-9]/i',
      ' ',
      $input
    ))));
  }
}
