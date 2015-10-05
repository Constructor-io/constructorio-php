Constructor-IO Python Client
=====

A PHP package for the [Constructor.io API](http://constructor.io/docs).  Constructor.io provides a lightning-fast, typo-tolerant autocomplete service that ranks your users' queries by popularity to let them find what they're looking for as quickly as possible.

Installation
===

-- add the composer instructions here when we upload

API
===

All of these are basically one step away from the RESTFUL interface and the implementation is dead simple.

Usage
---

Create a new instance with your API token and autocomplete key:

```php
require_once "ConstructorIO"
$constructor = new ConstructorIO("your API token","your autocomplete key")
# both of these are available at https://constructor.io/dashboard
```

If you ONLY want to query, then you can put in `""` for `apiToken`.

Querying
---

To query the autocomplete from your backend:

(If you are making a website, use our Javascript front-end client, it will be much faster for your users. Like, seriously.)

```php
>>> $suggestions = $constructor->query("a");
>>> $suggestions
array(
  "suggestions" => array(
    array("value"=> "ambulance"),
    array("value"=> "aardvark"),
    array("value"=> "Aachen")
  )
)
```

Changing the index
---

All of these methods return `true` if successful and raise an `Exception` with a description of what happened if not successful.

To add an item to your autocomplete index:
    
```php
>>> $constructor->add(
>>>  "boinkamoinka", // item name
>>>  "Search Suggestions" // autocomplete section name
>>> )
true
```

To remove an item from your autocomplete index:
    
```php
>>> $constructor->remove(
>>>   "boinkamoinka", // item name
>>>   "Search Suggestions" // autocomplete section name
>>> )
true
```

To modify an item in your autocomplete index:

```php
>>> $constructor->modify(
>>>   "boinkamoinka", // item name
>>>   "Search Suggestions", // autocomplete section name
>>>   array("suggested_score" => 100) // array of item properties to modify
>>> )
true
```

Tracking
---

You can also track behavioral data to improve the rankings of your results.  There are three tracking methods for search, click_through, and conversion:

All of these methods return `True` if successful and raise an `Exception` with a description of what happened if not successful.

Tracking a search event:

```php
>>> $constructor->trackSearch(
>>>   "boinkamoinka", // term name
>>>   "Search Suggestions" // autocomplete section name
>>>   array("num_results" => 200) // array of properties of the search
>>> )
true
```

Tracking a click-through event:

```php
>>> constructor.trackClickThrough(
>>>   "boinkamoinka", // term name
>>>   "Search Suggestions" // autocomplete section name
>>>   array("num_results" => 200) // array of properties of the click through
>>> )
true
```

Tracking a conversion event:
    
```php
>>> constructor.trackConversion(
>>>   "boinkamoinka", // term name
>>>   "Search Suggestions" // autocomplete section name
>>>   array("num_results" => 200) // array of properties of the conversion
>>> )
true
```

