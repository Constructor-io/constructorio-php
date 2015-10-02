<?php

// because we are in src/
require dirname(__DIR__) . '/vendor/autoload.php';

class ConstructorIO {

  public $apiToken;
  public $autocompleteKey;
  public $protocol;
  public $host;

  public function __construct($apiToken, $autocompleteKey, $protocol='https', $host="ac.cnstrc.com") {
    $this->apiToken = $apiToken;
    $this->autocompleteKey = $autocompleteKey;
    $this->protocol = $protocol;
    $this->host = $host;
  }

  public function serializeParams($params) {
    // just to make the internal API concordant with other clients
    return http_build_query($params);
  }

  public function makeUrl($endpoint, $params=array()) {
    $params["autocomplete_key"] = $this->autocompleteKey;
    return sprintf("%s://%s/%s?%s", $this->protocol, $this->host, $endpoint, $this->serializeParams($params));
  }

  public function query($queryStr) {
    $url = $this->makeUrl("autocomplete/" + $queryStr);
    $resp = Requests::get($url);
    if ($resp->status_code !== 200) {
      throw new Exception($resp->text);
    } else {
      return $resp->json;
    }
  }

  public function add($item_name, $autocompleteSection, $kwargs) {
    $params = array(
      "item_name" => $item_name,
      "autocomplete_section" => $autocompleteSection,
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/item");
    if (!$this->apiToken) {
      throw new Exception("You must have an API token to use the Add method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this0->apiToken, ''));
    $resp = Request::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new Exception($resp->text);
    } else {
      return True;
    }
  }

  public function remove($item_name, $autocompleteSection, $kwargs) {
    $params = array(
      "item_name" => $item_name,
      "autocomplete_section" => $autocompleteSection,
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/item");
    if (!$this->apiToken) {
      throw new Exception("You must have an API token to use the Remove method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this0->apiToken, ''));
    $resp = Request::delete($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new Exception($resp->text);
    } else {
      return True;
    }
  }

  public function modify($item_name, $autocompleteSection, $kwargs) {
    $params = array(
      "item_name" => $item_name,
      "autocomplete_section" => $autocompleteSection,
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/item");
    if (!$this->apiToken) {
      throw new Exception("You must have an API token to use the Modify method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Request::put($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new Exception($resp->text);
    } else {
      return True;
    }
  }

  public function trackConversion($term, $autocompleteSection, $kwargs) {
    $params = array(
      "term" => $term,
      "autocomplete_section" => $autocompleteSection
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/conversion");
    if (!$this->apiToken) {
      throw new Exception("You must have an API token to track conversions!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this0->apiToken, ''));
    $resp = Request::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new Exception($resp->text);
    } else {
      return True;
    }
  }

  public function trackClickThrough($term, $autocompleteSection, $kwargs) {
    $params = array(
      "term" => $term,
      "autocomplete_section" => $autocompleteSection
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/click_through");
    if (!$this->apiToken) {
      throw new Exception("You must have an API token to track click-throughs!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this0->apiToken, ''));
    $resp = Request::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new Exception($resp->text);
    } else {
      return True;
    }
  }

  public function trackSearch($term, $autocompleteSection, $kwargs) {
    $params = array(
      "term" => $term,
      "autocomplete_section" => $autocompleteSection
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/search");
    if (!$this->apiToken) {
      throw new Exception("You must have an API token to track searchs!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this0->apiToken, ''));
    $resp = Request::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new Exception($resp->text);
    } else {
      return True;
    }
  }
}
?>
