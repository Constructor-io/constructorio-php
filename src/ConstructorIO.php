<?php

require('requests');

class ConstructorIO {

  public function __construct($apiToken, $autocompleteKey, $protocol='http', $host=something) {
        //python:
        //self._api_token = api_token
        //self._autocomplete_key = autocomplete_key
        //self._protocol = protocol
        //self._host = host
  }

  private function _serializeParams($params) {
        //python:
        //return urllib.urlencode(params)
  }

  private function _makeUrl($endpoint, $params=array()) {
        //python:
        //if not params:
        //    params = {}
        //params["autocomplete_key"] = self._autocomplete_key
        //return "{0}://{1}/{2}?{3}".format(self._protocol, self._host, endpoint, self._serialize_params(params))
  }

  public function query($queryStr) {
        //python:
        //url = self._make_url("autocomplete/" + query_str)
        //resp = requests.get(url)
        //if resp.status_code != 200:
        //    raise IOError(resp.text)
        //else:
        //    return resp.json()
  }

  public function add($item_name, $autocomplete_section, $kwargs) {
        //python:
        //params = {"item_name": item_name, "autocomplete_section": autocomplete_section}
        //if "suggested_score" in kwargs:
        //    params["suggested_score"] = kwargs["suggested_score"]
        //if "keywords" in kwargs:
        //    params["keywords"] = kwargs["keywords"]
        //if "description" in kwargs:
        //    params["description"] = kwargs["description"]
        //if "url" in kwargs:
        //    params["url"] = kwargs["url"]
        //if "image_url" in kwargs:
        //    params["image_url"] = kwargs["image_url"]
        //url = self._make_url("v1/item")
        //if not self._api_token:
        //    raise IOError("You must have an API token to use the Add method!")
        //resp = requests.post(
        //    url,
        //    json=params,
        //    auth=(self._api_token, "")
        //)
        //if resp.status_code != 204:
        //    raise IOError(resp.text)
        //else:
        //    return True
  }

  public function remove($item_name, $autocomplete_section, $kwargs) {
        //python
        //params = {"item_name": item_name, "autocomplete_section": autocomplete_section}
        //if "suggested_score" in kwargs:
        //    params["suggested_score"] = kwargs["suggested_score"]
        //if "keywords" in kwargs:
        //    params["keywords"] = kwargs["keywords"]
        //if "url" in kwargs:
        //    params["url"] = kwargs["url"]
        //url = self._make_url("v1/item")
        //if not self._api_token:
        //    raise IOError("You must have an API token to use the Remove method!")
        //resp = requests.delete(
        //    url,
        //    json=params,
        //    auth=(self._api_token, "")
        //)
        //if resp.status_code != 204:
        //    raise IOError(resp.text)
        //else:
        //    return True
  }
  
  public function modify($item_name, $autocomplete_section, $kwargs) {
        //python
        //params = {"item_name": item_name, "autocomplete_section": autocomplete_section}
        //if "suggested_score" in kwargs:
        //    params["suggested_score"] = kwargs["suggested_score"]
        //if "keywords" in kwargs:
        //    params["keywords"] = kwargs["keywords"]
        //if "url" in kwargs:
        //    params["url"] = kwargs["url"]
        //url = self._make_url("v1/item")
        //if not self._api_token:
        //    raise IOError("You must have an API token to use the Modify method!")
        //resp = requests.put(
        //    url,
        //    json=params,
        //    auth=(self._api_token, "")
        //)
        //if resp.status_code != 204:
        //    raise IOError(resp.text)
        //else:
        //    return True
  }

  public function track_conversion($term, $autocomplete_section, $kwargs) {
    //python:
        //params = {
        //    "term": term,
        //    "autocomplete_section": autocomplete_section,
        //}
        //if "item" in kwargs:
        //    params["item"] = kwargs["item"]
        //url = self._make_url("v1/conversion")
        //if not self._api_token:
        //    raise IOError("You must have an API token to track conversions!")
        //resp = requests.post(
        //    url,
        //    json=params,
        //    auth=(self._api_token, "")
        //)
        //if resp.status_code != 204:
        //    raise IOError(resp.text)
        //else:
        //    return True
  }
  
  public function track_click_through($term, $autocomplete_section, $kwargs) {
    //python
        //params = {
        //    "term": term,
        //    "autocomplete_section": autocomplete_section,
        //}
        //if "item" in kwargs:
        //    params["item"] = kwargs["item"]
        //if "revenue" in kwargs:
        //    params["revenue"] = kwargs["revenue"]
        //url = self._make_url("v1/click_through")
        //if not self._api_token:
        //    raise IOError("You must have an API token to track click throughs!")
        //resp = requests.post(
        //    url,
        //    json=params,
        //    auth=(self._api_token, "")
        //)
        //if resp.status_code != 204:
        //    raise IOError(resp.text)
        //else:
        //    return True
  }
  
  public function track_search($term, $autocomplete_section, $kwargs) {
    //python
        //params = {
        //    "term": term,
        //    "autocomplete_section": autocomplete_section,
        //}
        //if "num_results" in kwargs:
        //    params["num_results"] = kwargs["num_results"]
        //url = self._make_url("v1/search")
        //if not self._api_token:
        //    raise IOError("You must have an API token to track searches!")
        //resp = requests.post(
        //    url,
        //    json=params,
        //    auth=(self._api_token, "")
        //)
        //if resp.status_code != 204:
        //    raise IOError(resp.text)
        //else:
        //    return True
  }
}
?>
