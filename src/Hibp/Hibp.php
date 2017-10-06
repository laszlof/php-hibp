<?php

namespace Hibp;

use Hibp\Models\Breach;
use Hibp\Models\Paste;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Stream;

/**
 * Hibp Service class
 *
 * @package Hibp
 */
class Hibp {

  /**
   * Library Version
   * @var string
   */
  const VERSION = '0.1.2';

  /**
   * API Version
   * @var int
   */
  const API_VERSION  = 2;

  /**
   * Endpoint URL
   * @var string
   */
  const ENDPOINT_URL = 'https://haveibeenpwned.com/api/';

  /**
   * Library user-agent string
   * @var string
   */
  const USER_AGENT = 'php-hibp library';


  /**
   * Get a single breach by name.
   *
   * @param string $name Name of breach
   * @return Breach
   * @see https://haveibeenpwned.com/API/v2#SingleBreach
   */
  static public function getBreach(string $name) : Breach {
    $resp = self::apiCall('breach', $name);
    return new Breach(json_decode($resp));
  }

  /**
   * Get all breaches for an account
   *
   * @param string $account Username or Email address of account to check.
   * @return Breach[]
   * @see https://haveibeenpwned.com/API/v2#BreachesForAccount
   */
  static public function getBreaches(string $account) : array {
    $resp = self::apiCall('breachedaccount', $account);
    $result = [];
    foreach (json_decode($resp) as $br) {
      $result[] = new Breach($br);
    }

    return $result;
  }

  /**
   * Get a list of sites that have been breached
   *
   * @param string $domain Filter by domain
   * @return Breach[]
   * @see https://haveibeenpwned.com/API/v2#AllBreaches
   */
  static public function getBreachedSites(string $domain = null) : array {
    $data = (! is_null($domain)) ? ['domain' => $domain] : [];
    $resp = self::apiCall('breaches', null, $data);

    $result = [];
    foreach (json_decode($resp) as $br) {
      $result[] = new Breach($br);
    }

    return $result;
  }

  /**
   * Get a list of the types of dataclasses
   *
   * @return array
   * @see https://haveibeenpwned.com/API/v2#AllDataClasses
   */
  static public function getDataClasses() : array {
    $resp = self::apiCall('dataclasses');

    return json_decode($resp);

  }

  /**
   * Get all pastes for an account
   *
   * @param string $account Username or Email address of account to check.
   * @return Paste[]
   * @see https://haveibeenpwned.com/API/v2#PastesForAccount
   */
  static public function getPastes(string $account) : array {
    $resp = self::apiCall('pasteaccount', $account);

    $result = [];
    foreach (json_decode($resp) as $br) {
      $result[] = new Paste($br);
    }

    return $result;
  }

  /**
   * Check to see if a password is listed
   *
   * @param string $password The password to check
   * @param bool $hash Set to true if the password is a hash itself
   * @return bool
   * @see https://haveibeenpwned.com/API/v2#PwnedPasswords
   */
  static public function checkPassword(
    string $password,
    bool $hash = false
  ) : bool {
    $data = ($hash) ? ['originalPasswordIsAHash' => true] : [];
    try {
      $resp = self::apiCall('pwnedpassword', $password, $data, true);
    } catch (\Throwable $e) {
      return false;
    }

    return true;
  }

  /**
   * Make a request to the API
   *
   * @param string $service The service requested
   * @param string $param The parameter for this service
   * @param array $data Additional data to pass with the request
   * @param bool $throw Throw for all non-200 responses
   * @throws \Exception
   * @return \GuzzleHttp\Psr7\Stream
   */
  static public function apiCall(
    string $service,
    string $param = null,
    array $data = [],
    bool $throw = false
  ) : Stream {
    $client = new Client([
      'base_uri' => self::ENDPOINT_URL,
      'headers' => [
        'api-version' => self::API_VERSION,
        'User-Agent' => self::USER_AGENT
      ]
    ]);
    $url = (is_null($param)) ? $service : "$service/$param";
    if (! empty($data)) {
      $url .= '?' . http_build_query($data);
    }
    $resp = $client->request('GET', $url);
    if ($throw && $resp->getStatusCode() !== 200) {
      throw new \Exception("Status Code: {$resp->getStatusCode()}");
    }
    switch ($resp->getStatusCode()) {
      case 200:
        return $resp->getBody();
        break;
      case 400:
        throw new \Exception('Bad Request');
        break;
      case 403:
        throw new \Exception('Forbidden Request (Missing User-Agent?)');
        break;
      case 404:
        return [];
        break;
      case 429: /* Rate Limit Request */
        $retry = $resp->getHeader('Retry-After');
        sleep((int)$retry);
        return self::apiCall($service, $param, $data);
        break;
      default:
        throw new \Exception('Invalid Return Code');
        break;
    }
  }
}
