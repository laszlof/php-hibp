<?php

use Hibp\Hibp;
use Hibp\Models\Breach;
use Hibp\Models\Paste;

use PHPUnit\Framework\TestCase;

class HibpTest extends TestCase {
  /**
   * Hibp Object
   * @var Hibp\Hibp
   */
  protected $_hibp;

  /**
   * Setup the tests
   */
   protected function setUp() {
     $this->_hibp = new Hibp();
   }

  public function testGetBreach() {
    $mock = $this->_getMockData(
      $this->_hibp::ENDPOINT_URL .
      'v' . $this->_hibp::API_VERSION .
      '/breach/Adobe'
    );
    $test = $this->_hibp->getBreach('Adobe');

    $this->_assertBreach($test, json_decode($mock));
  }

  public function testGetBreaches() {
    $mock = $this->_getMockData(
      $this->_hibp::ENDPOINT_URL .
      'v' . $this->_hibp::API_VERSION .
      '/breachedaccount/test@example.com'
    );
    $test = $this->_hibp->getBreaches('test@example.com');

    $mock = json_decode($mock);
    $this->assertCount(count($mock), $test);
    for ($i = 0; $i < count($mock); $i++) {
      $this->_assertBreach($test[$i], (object)$mock[$i]);
    }
  }

  public function testGetBreachedSites() {
    $mock = $this->_getMockData(
      $this->_hibp::ENDPOINT_URL .
      'v' . $this->_hibp::API_VERSION .
      '/breaches'
    );
    $test = $this->_hibp->getBreachedSites();

    $mock = json_decode($mock);
    $this->assertCount(count($mock), $test);
    for ($i = 0; $i < count($mock); $i++) {
      $this->_assertBreach($test[$i], (object)$mock[$i]);
    }
  }

  public function testGetDataClasses() {
    $mock = $this->_getMockData(
      $this->_hibp::ENDPOINT_URL .
      'v' . $this->_hibp::API_VERSION .
      '/dataclasses'
    );
    $test = $this->_hibp->getDataClasses();

    $mock = json_decode($mock);
    $this->assertCount(count($mock), $test);
  }

  public function testGetPastes() {
    $mock = $this->_getMockData(
      $this->_hibp::ENDPOINT_URL .
      'v' . $this->_hibp::API_VERSION .
      '/pasteaccount/test@example.com'
    );
    $test = $this->_hibp->getPastes('test@example.com');

    $mock = json_decode($mock);
    $this->assertCount(count($mock), $test);
    for ($i = 0; $i < count($mock); $i++) {
      $this->_assertPaste($test[$i], (object)$mock[$i]);
    }
  }

  public function testCheckPassword() {
    $passwords = [
      'P@55w0rd',
      'DjsdflkjhfkJHKDJFHLDSKFJHFLKJDSFHLDKSFGDFHJGDFKJSDHFGDJKHFgjfhgsfdkjhd',
      'password123'
    ];

    foreach ($passwords as $pw) {
      $url = $this->_hibp::ENDPOINT_URL .
        'v' . $this->_hibp::API_VERSION .
        "/pwnedpassword/{$pw}";
      $options = [
        'http' => ['user_agent' => $this->_hibp::USER_AGENT]];
      $context = stream_context_create($options);
      @file_get_contents($url, false, $context);
      preg_match('~[0-9]{3}~', $http_response_header[0], $m);
      $found = (int)$m[0] === 200;
      $this->assertEquals($this->_hibp->checkPassword($pw), $found);

      // Sleep to avoid rate limiting
      sleep(1);
    }
  }

  /**
   * Breach Assertions
   *
   * @param Breach $test Our tested output
   * @param \stdClass $mock Our fetched mock data
   */
  private function _assertBreach(Breach $test, \stdClass $mock) {
    $this->assertInstanceOf(Breach::class, $test);
    $this->assertEquals($test->title, $mock->Title);
    $this->assertEquals($test->name, $mock->Name);
    $this->assertEquals($test->domain, $mock->Domain);
    $this->assertEquals($test->breachDate, $mock->BreachDate);
    $this->assertEquals($test->addedDate, $mock->AddedDate);
    $this->assertEquals($test->modifiedDate, $mock->ModifiedDate);
    $this->assertEquals($test->pwnCount, $mock->PwnCount);
    $this->assertEquals($test->description, $mock->Description);
    $this->assertEquals($test->dataClasses, $mock->DataClasses);
    $this->assertEquals($test->isVerified, $mock->IsVerified);
    $this->assertEquals($test->isFabricated, $mock->IsFabricated);
    $this->assertEquals($test->isSensitive, $mock->IsSensitive);
    $this->assertEquals($test->isRetired, $mock->IsRetired);
    $this->assertEquals($test->isSpamList, $mock->IsSpamList);
  }

  /**
   * Paste Assertions
   *
   * @param Paste $test Our tested output
   * @param \stdClass $mock Our fetched mock data
   */
  private function _assertPaste(Paste $test, \stdClass $mock) {
    $this->assertInstanceOf(Paste::class, $test);
    $this->assertEquals($test->source, $mock->Source);
    $this->assertEquals($test->id, $mock->Id);
    $this->assertEquals($test->title, $mock->Title);
    $this->assertEquals($test->date, $mock->Date);
    $this->assertEquals($test->emailCount, $mock->EmailCount);
  }

  /**
   * get our mock data to compare
   *
   * @param string $url Url to grab
   * @return string
   */
  private function _getMockData(string $url) : string {
    $options = [
      'http' => ['user_agent' => $this->_hibp::USER_AGENT]];
    $context = stream_context_create($options);
    // Sleep to avoid rate limiting
    sleep(1);
    return file_get_contents($url, false, $context);
  }
}
