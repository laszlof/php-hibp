<?php

namespace Hibp\Models;

/**
 * Class representing a Hibp Paste
 *
 * @see https://haveibeenpwned.com/API/v2#PasteModel
 * @package Hibp
 * @subpackage Models
 */

class Paste extends Model {

  /**
   * The paste service the record was retrieved from.
   * @var string
   */
  public $source;

  /**
   * The ID of the paste as it was given at the source service.
   * @var string
   */
  public $id;

  /**
   * The title of the paste as observed on the source site.
   * @var string
   */
  public $title;

  /**
   * The date and time (precision to the second) that the paste was posted.
   * @var string
   */
  public $date;

  /**
   * The number of emails that were found when processing the paste.
   * @var string
   */
  public $emailCount;

}
