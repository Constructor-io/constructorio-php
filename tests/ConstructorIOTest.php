<?php

require_once "src/ConstructorIO.php";
use ConstructorIO\ConstructorIO;

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
   * The official fake account apiToken is YSOxV00F0Kk2R0KnPQN8
   * The official fake account acKey is ZqXaOfXuBWD4s3XzCI1q
   */
  
  public function testHealthCheck() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->healthCheck();
    $resp_json = json_decode($resp, true);
    $this->assertTrue($resp_json["is_up"]);
  }

  public function testVerify() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->verify();
    $resp_json = json_decode($resp, true);
    $this->assertEquals($resp_json["message"], "successful authentication");
  }

  public function testACQuery() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    // let's have api token and ac key plox
    $autocompletes = $constructor->query("S");
    $this->assertNotNull($autocompletes);
    $this->assertArrayHasKey("sections", $autocompletes);
    $this->assertArrayHasKey("Search Suggestions", $autocompletes["sections"]);
  }

  public function testAddOrUpdate() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $randItem = substr(md5(rand()), 0, 7);
    $resp = $constructor->addOrUpdate($randItem, "Search Suggestions");
    $randItem2 = substr(md5(rand()), 0, 7);
    $params = array("id" => $randItem2, "url" => "/some/url/for/" . $randItem2, "custome_param" => "blah",
                    "description" => "Привет! test description", "keywords" => array("w1", "w2"));
    $resp = $constructor->addOrUpdate("Привет" . $randItem2, "Products", $params);
    $this->assertTrue($resp);
    $params["descriptions"] = "blah";
    $resp = $constructor->addOrUpdate("Привет" . $randItem2, "Products", $params);
    $this->assertTrue($resp);
    $resp = $constructor->addOrUpdate("some new name", "Products", $params);
    $this->assertTrue($resp);
  }

  public function testAddOrUpdateBatch() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $item1 = substr(md5(rand()), 0, 7);
    $item2 = substr(md5(rand()), 0, 7);
    $item3 = substr(md5(rand()), 0, 7);
    $randItems = array(
      array("item_name" => $item1, "suggested_score" => 15,
            "url" => "/some/url1"),
      array("item_name" => $item2, "suggested_score" => 17,
            "url" => "/some/url2", "image_url" => "/some/image2"),
      array("item_name" => $item3, "url" => "/some/url3",
            "image_url" => "/some/image3")
    );
    $resp = $constructor->addOrUpdateBatch($randItems, "Products");
    $this->assertTrue($resp);
    $randItems[0]["suggested_score"] = 50;
    $randItems[1]["image_url"] = "/some/other/image";
    $randItems[2]["url"] = "/some/new/url";
    $resp = $constructor->addOrUpdateBatch($randItems, "Products");
    $this->assertTrue($resp);
  }

  public function testAdd() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $randItem = substr(md5(rand()), 0, 7);
    $resp = $constructor->add($randItem, "Search Suggestions");
    $randItem2 = substr(md5(rand()), 0, 7);
    $params = array("id" => $randItem2, "url" => "/some/url/for/" . $randItem2, "custome_param" => "blah",
                    "description" => "Привет! test description", "keywords" => array("w1", "w2"));
    $resp = $constructor->add("Привет" . $randItem2, "Products", $params);
    $this->assertTrue($resp);
  }

  public function testAddBatch() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $item1 = substr(md5(rand()), 0, 7);
    $item2 = substr(md5(rand()), 0, 7);
    $item3 = substr(md5(rand()), 0, 7);
    $randItems = array(
      array("item_name" => $item1, "suggested_score" => 15,
            "url" => "/some/url1"),
      array("item_name" => $item2, "suggested_score" => 17,
            "url" => "/some/url2", "image_url" => "/some/image2"),
      array("item_name" => $item3, "url" => "/some/url3",
            "image_url" => "/some/image3")
    );
    $resp = $constructor->addBatch($randItems, "Products");
    $this->assertTrue($resp);
  }

  public function testAddOptional() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $randItem = substr(md5(rand()), 0, 7);
    $kwargs = array(
      "suggested_score" => 1337
    );
    $resp = $constructor->add($randItem, "Search Suggestions", $kwargs);
    $this->assertTrue($resp);
  }

  public function testRemove() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    // this is live state, folks
    $randItem = substr(md5(rand()), 0, 7);
    $resp_add = $constructor->add($randItem, "Search Suggestions");
    $this->assertTrue($resp_add);
    sleep(2); // because item addition may be made async
    $resp = $constructor->remove($randItem, "Search Suggestions");
    $this->assertTrue($resp);
  }

  public function testRemoveBatch() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    // this is live state, folks
    $item1 = substr(md5(rand()), 0, 7);
    $item2 = substr(md5(rand()), 0, 7);
    $item3 = substr(md5(rand()), 0, 7);
    $randItems = array(
      array("item_name" => $item1, "suggested_score" => 15,
            "url" => "/some/url1"),
      array("item_name" => $item2, "suggested_score" => 17,
            "url" => "/some/url2", "image_url" => "/some/image2"),
      array("item_name" => $item3, "url" => "/some/url3",
            "image_url" => "/some/image3")
    );
    $resp_add = $constructor->addBatch($randItems, "Products");
    $this->assertTrue($resp_add);
    $resp_del = $constructor->removeBatch($randItems, "Products");
    $this->assertTrue($resp_del);
  }

  // no optional params for remove

  public function testModify() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $randItem = substr(md5(rand()), 0, 7);
    $resp_add = $constructor->add($randItem, "Search Suggestions");
    $this->assertTrue($resp_add);
    sleep(2); // because item addition may be made async
    $resp = $constructor->modify($randItem, $randItem, "Search Suggestions", array("suggested_score" => 100));
    $this->assertTrue($resp);
  }

  public function testModifyOptional() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $randItem = substr(md5(rand()), 0, 7);
    $resp_add = $constructor->add($randItem, "Search Suggestions");
    $this->assertTrue($resp_add);
    sleep(2); // because item addition may be made async
    $kwargs = array(
      "suggested_score" => 1337
    );
    $resp = $constructor->modify($randItem, $randItem, "Search Suggestions", $kwargs);
    $this->assertTrue($resp);
  }

  public function testConversion() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackConversion("Stanley_Steamer", "Search Suggestions");
    $this->assertTrue($resp);
  }

  public function testConversionOptional() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $randItem = substr(md5(rand()), 0, 7);
    $resp_add = $constructor->add($randItem, "Search Suggestions");
    $this->assertTrue($resp_add);
    sleep(2); // because item addition may be made async
    $resp = $constructor->trackSearch("Stanley_Steamer", array("item" => $randItem));
  }
  
  public function testSearch() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackSearch("Stanley_Steamer");
    $this->assertTrue($resp);
  }

  public function testSearchOptional() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackSearch("Stanley_Steamer", array("num_results" => 10));
    $this->assertTrue($resp);
  }

  public function testClickThrough() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $resp = $constructor->trackClickThrough("Stanley_Steamer", "Search Suggestions");
    $this->assertTrue($resp);
  }

  public function testClickThroughOptional() {
    $constructor = new ConstructorIO("YSOxV00F0Kk2R0KnPQN8", "ZqXaOfXuBWD4s3XzCI1q");
    $randItem = substr(md5(rand()), 0, 7);
    $resp_add = $constructor->add($randItem, "Search Suggestions");
    $this->assertTrue($resp_add);
    sleep(2); // because item addition may be made async
    $kwargs = array(
      "item" => $randItem,
      "revenue" => 1337
    );
    $resp = $constructor->trackClickThrough("Stanley_Steamer", "Search Suggestions", $kwargs);
    $this->assertTrue($resp);
  }
}

?>
