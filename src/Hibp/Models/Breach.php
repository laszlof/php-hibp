<?php

namespace Hibp\Models;

/**
 * Class representing a Hibp Breach
 *
 * @see https://haveibeenpwned.com/API/v2#BreachModel
 * @package Hibp
 * @subpackage Models
 */

class Breach extends Model {

  /**
   * A Pascal-cased name representing the breach which is unique across all
   * other breaches.
   * @var string
   */
  public $name;

  /**
   * A descriptive title for the breach suitable for displaying to end users.
   * @var string
   */
  public $title;

  /**
   * The domain of the primary website the breach occurred on.
   * @var string
   */
  public $domain;

  /**
   * The date (with no time) the breach originally occurred on in ISO 8601
   * format.
   * @var string
   */
  public $breachDate;

  /**
   * The date and time (precision to the minute) the breach was added to the
   * system in ISO 8601 format.
   * @var string
   */
  public $addedDate;

  /**
   * The date and time (precision to the minute) the breach was modified in
   * ISO 8601 format.
   * @var string
   */
  public $modifiedDate;

  /**
   * The total number of accounts loaded into the system.
   * @var int
   */
  public $pwnCount;

  /**
   * Contains an overview of the breach represented in HTML markup.
   * @var string
   */
  public $description;

  /**
   * This attribute describes the nature of the data compromised in the breach
   * and contains an alphabetically ordered string array of impacted data
   * classes.
   * @var array
   */
  public $dataClasses;

  /**
   * Indicates that the breach is considered unverified.
   * @var bool
   */
  public $isVerified;

  /**
   * Indicates that the breach is considered fabricated.
   * @var bool
   */
  public $isFabricated;

  /**
   * Indicates if the breach is considered sensitive.
   * @var bool
   */
  public $isSensitive;

  /**
   * Indicates if the breach has been retired.
   * @var bool
   */
  public $isRetired;

  /**
   * Indicates if the breach is considered a spam list.
   * @var bool
   */
  public $isSpamList;
}
