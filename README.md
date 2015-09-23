[![Build Status](https://travis-ci.org/davewwww/Aggregator.svg)](https://travis-ci.org/davewwww/Aggregator) [![Coverage Status](https://coveralls.io/repos/davewwww/Aggregator/badge.svg)](https://coveralls.io/r/davewwww/Aggregator)

Aggregator
----------
collect, group & aggregate data

```php
$collector = new Collector(array('country'));
$collector->addEntry(['country' => 'DE', 'counts'=>1]);
$collector->addEntry(['country' => 'DE', 'counts'=>2]);

$aggregate = Aggregator::aggregate($collector)->getEntryByKey('DE');

print_r($aggregate->getData());
```

```php
Array
(
    [country] => DE
    [counts] => 3
)
```

Merger
------
merge two arrays

```php
$origin = ['counts' => 1];
$merge = ['counts' => 2];

Merger::merge($origin, $merge);

print_r($origin);
```

```php
Array
(
    [counts] => 3
)
```