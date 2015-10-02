<?php

require_once "src/ConstructorIO.php";

class ConstructorIOTest extends PHPUnit_Framework_TestCase {

  public function testEncodesParameters() {
    $constructor = new ConstructorIO("boinka", "doinka");
    $params = array("foo" => array(1,2), "bar" => array("baz" => array("a", "b")));
    $serializedParams = $constructor->serializeParams($params);
    $this->assertEquals($serializedParams,"foo%5B0%5D=1&foo%5B1%5D=2&bar%5Bbaz%5D%5B0%5D=a&bar%5Bbaz%5D%5B1%5D=b");
  }

  public function testCreatesUrlsCorrectly() {
    $constructor = new ConstructorIO("boinka", "a-test-autocomplete-key");
    $generatedUrl = $constructor->makeUrl('v1/test');
    $this->assertEquals($generatedUrl, "https://ac.cnstrc.com/v1/test?autocomplete_key=a-test-autocomplete-key");
  }

  public function testSetApiToken() {
    $apiToken = 'a-test-api-key';
    $constructor = new ConstructorIO($apiToken, "boinka");
    $this->assertEquals($apiToken, $constructor->apiToken);
  }

  public function testSetACKey() {
    $autocompleteKey = 'a-test-autocomplete-key';
    $constructor = new ConstructorIO("boinka", $autocompleteKey);
    $this->assertEquals($autocompleteKey, $constructor->autocompleteKey);
  }

  /*
   * The official fake account apiToken is tkmWVnG0xHXPR0XSdRHA
   * The official fake account acKey is ZqXaOfXuBWD4s3XzCI1q
   */

  public function testACQuery() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    // let's have api token and ac key plox
    $autocompletes = $constructor->query("a");
    $this->assertNotNull($autocompletes);
    $this->assertArrayHasKey("suggestions", $autocompletes);
  }

  public function testAdd() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->add("boinkamoinka", "Search Suggestions");
    $this->assertTrue($resp);
  }

  public function testRemove() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    // this is live state, folks
    $resp_add = $constructor->add("foinkadoinkamoinka", "Search Suggestions");
    $resp = $constructor->remove("foinkadoinkamoinka", "Search Suggestions");
    $this->assertTrue($resp);
  }

  public function testModify() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->modify("Stanley_Steamer", "Search Suggestions", array("suggested_score" => 100));
    $this->assertTrue($resp);
  }

  public function testConversion() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackConversion("Stanley_Steamer", "Search Suggestions");
    $this->assertTrue($resp);
  }

  public function testSearchNoRes() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackSearch("Stanley_Steamer", "Search Suggestions");
    $this->assertTrue($resp);
  }

  public function testSearchRes() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackSearch("Stanley_Steamer", "Search Suggestions", array("num_results" => 10));
    $this->assertTrue($resp);
  }

  public function testClickThrough() {
    $constructor = new ConstructorIO("tkmWVnG0xHXPR0XSdRHA", "acKeyZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackClickThrough("Stanley_Steamer", "Search Suggestions");
    $this->assertTrue($resp);
  }
}

?>
