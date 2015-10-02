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

  public function testACQuery() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/query-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        autocompletes = constructor.query(
    //            query_str = "a"
    //        )
    //        assert autocompletes != None
    //        assert type(autocompletes) == dict
  }

  public function testAdd() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/add-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        resp = constructor.add(
    //            item_name = "boinkamoinka",
    //            autocomplete_section = "Search Suggestions"
    //        )
    //        assert resp == True
  }

  public function testRemove() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/remove-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        resp = constructor.remove(
    //            item_name = "racer",
    //            autocomplete_section = "Search Suggestions"
    //        )
    //        assert resp == True
  }

  public function testModify() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/modify-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        resp = constructor.modify(
    //            item_name = "Stanley_Steamer",
    //            suggested_score = 100,
    //            autocomplete_section = "Search Suggestions"
    //        )
    //        assert resp == True
  }

  public function testConversion() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/conversion-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        resp = constructor.track_conversion(
    //            term = "Stanley_Steamer",
    //            autocomplete_section = "Search Suggestions"
    //        )
    //        assert resp == True
  }

  public function testSearchNoRes() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/search-noname-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        resp = constructor.track_search(
    //            term = "Stanley_Steamer",
    //            num_results = 10,
    //            autocomplete_section = "Search Suggestions"
    //        )
    //        assert resp == True
  }

  public function testSearchRes() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/search-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        resp = constructor.track_search(
    //            term = "Stanley_Steamer",
    //            num_results = 10,
    //            autocomplete_section = "Search Suggestions"
    //        )
    //        assert resp == True
  }

  public function testClickThrough() {
    //    with vcr.use_cassette("fixtures/ac.cnstrc.com/click-through-success.yaml"):
    //        constructor = ConstructorIO(
    //            api_token = "apiToken",
    //            autocomplete_key = "autocompleteKey",
    //            protocol = "http",
    //            host = "ac.cnstrc.com"
    //        )
    //        resp = constructor.track_click_through(
    //            term = "Stanley_Steamer",
    //            autocomplete_section = "Search Suggestions"
    //        )
    //        assert resp == True
  }
}

?>
