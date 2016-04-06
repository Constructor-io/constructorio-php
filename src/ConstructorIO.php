<?php

namespace ConstructorIO;

use Requests;

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
    if ($params === array()) {
      $params["autocomplete_key"] = $this->autocompleteKey;
    }
    return http_build_query($params);
  }

  public function makeUrl($endpoint, $params=array()) {
    $params["autocomplete_key"] = $this->autocompleteKey;
    return sprintf("%s://%s/%s?%s", $this->protocol, $this->host, $endpoint, $this->serializeParams($params));
  }

  public function healthCheck() {
    $url = $this->makeUrl("v1/health_check");
    $resp = Requests::get($url);
    if ($resp->status_code !== 200) {
      throw new ConstructorException($resp->body);
    } else {
      return $resp->body;
    }
  }

  public function verify() {
    $url = $this->makeUrl("v1/verify");
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to verify requests!");
    }
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::get($url, array(), $options);
    if ($resp->status_code !== 200) {
      throw new ConstructorException($resp->body);
    } else {
      return $resp->body;
    }
  }

  public function query($queryStr) {
    $url = $this->makeUrl("autocomplete/" . $queryStr);
    $resp = Requests::get($url);
    if ($resp->status_code !== 200) {
      throw new ConstructorException($resp->body);
    } else {
      return json_decode($resp->body, true);
    }
  }

  public function addBatch($items, $autocompleteSection) {
    $url = $this->makeUrl("v1/batch_items");
    $params = array(
      "items" => $items,
      "autocomplete_section" => $autocompleteSection,
    );
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to use the Add method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new ConstructorException($resp->body);
    } else {
      return true;
    }
  }

  public function add($item_name, $autocompleteSection, $kwargs=array()) {
    $params = array(
      "item_name" => $item_name,
      "autocomplete_section" => $autocompleteSection,
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/item");
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to use the Add method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new ConstructorException($resp->body);
    } else {
      return true;
    }
  }

  public function addOrUpdate($item_name, $autocompleteSection, $kwargs=array()) {
    $params = array(
      "item_name" => $item_name,
      "autocomplete_section" => $autocompleteSection,
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/item", array("force" => 1));
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to use the Add method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::put($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new ConstructorException($resp->body);
    } else {
      return true;
    }
  }


  public function addOrUpdateBatch($items, $autocompleteSection) {
    $url = $this->makeUrl("v1/batch_items", array("force" => 1));
    $params = array(
      "items" => $items,
      "autocomplete_section" => $autocompleteSection,
    );
    if (!$this->apiToken) {
       throw new ConstructorException("You must have an API token to use the addOrUpdateBatch method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::put($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
       throw new ConstructorException($resp->body);
    } else {
       return true;
    }
 }

  public function remove($item_name, $autocompleteSection, $kwargs=array()) {
    // Extremely stupid because of a flaw in Requests library
    $params = array(
      "item_name" => $item_name,
      "autocomplete_section" => $autocompleteSection,
    );
    $params = array_merge($params, $kwargs);
    $data = json_encode($params);
    $url = $this->makeUrl("v1/item");
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to use the Remove method!");
    }
    // the delete api on requests can't have data
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_USERPWD, $this->apiToken . ":");
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    $result = json_decode($result);
    // get the status code
    if ($httpCode !== 204) {
      throw new ConstructorException($result);
    } else {
      return true;
    }
  }

  public function modify($item_name, $new_item_name, $autocompleteSection, $kwargs=array()) {
    $params = array(
      "item_name" => $item_name,
      "new_item_name" => $new_item_name,
      "autocomplete_section" => $autocompleteSection,
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/item");
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to use the Modify method!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::put($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new ConstructorException($resp->body);
    } else {
      return true;
    }
  }

  public function trackConversion($term, $autocompleteSection, $kwargs=array()) {
    $params = array(
      "term" => $term,
      "autocomplete_section" => $autocompleteSection
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/conversion");
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to track conversions!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new ConstructorException($resp->body);
    } else {
      return true;
    }
  }

  public function trackClickThrough($term, $autocompleteSection, $kwargs=array()) {
    $params = array(
      "term" => $term,
      "autocomplete_section" => $autocompleteSection
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/click_through");
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to track click-throughs!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new ConstructorException($resp->body);
    } else {
      return true;
    }
  }

  public function trackSearch($term, $kwargs=array()) {
    $params = array(
      "term" => $term
    );
    $params = array_merge($params, $kwargs);
    $url = $this->makeUrl("v1/search");
    if (!$this->apiToken) {
      throw new ConstructorException("You must have an API token to track searchs!");
    }
    $headers = array('Content-Type' => 'application/json');
    $options = array('auth' => array($this->apiToken, ''));
    $resp = Requests::post($url, $headers, json_encode($params), $options);
    if ($resp->status_code !== 204) {
      throw new ConstructorException($resp->body);
    } else {
      return true;
    }
  }
}
?>
