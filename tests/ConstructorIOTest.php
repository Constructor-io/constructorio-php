<?php

class ConstructorIOTest extends PHPUnit_Framework_TestCase {

  public function testEncodesParameters() {
    $constructor = new ConstructorIO("boinka", "doinka");
    $params = array("foo" => array(1,2), "bar" => array("baz" => array("a", "b")));
    $serialized_params = $constructor->serializeParams($params);
    $this->assertEqual(serialized_params,"foo=%5B1%2C+2%5D&bar=%7B%27baz%27%3A+%5B%27a%27%2C+%27b%27%5D%7D");
  }

  public function testCreatesUrlsCorrectly() {
    //  constructor = ConstructorIO(api_token="boinka", autocomplete_key="a-test-autocomplete-key")
    //  generated_url = constructor._make_url('v1/test')
    //  assert generated_url == 'https://ac.cnstrc.com/v1/test?autocomplete_key=a-test-autocomplete-key'
  }

  public function testSetApiToken() {
    //  api_token = 'a-test-api-key',
    //  constructor = ConstructorIO(api_token=api_token, autocomplete_key="boinka")
    //  assert constructor._api_token == api_token
  }

  public function testSetACKey() {
    //    autocomplete_key = 'a-test-autocomplete-key'
    //    constructor = ConstructorIO(autocomplete_key=autocomplete_key, api_token="boinka")
    //    assert constructor._autocomplete_key == autocomplete_key
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
