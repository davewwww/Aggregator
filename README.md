[![Build Status](https://travis-ci.org/davewwww/Aggregator.svg)](https://travis-ci.org/davewwww/Aggregator) [![Coverage Status](https://coveralls.io/repos/davewwww/Aggregator/badge.svg)](https://coveralls.io/r/davewwww/Aggregator) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/davewwww/Aggregator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/davewwww/Aggregator/?branch=master)

Aggregator
----------
collect, group & aggregate data

```php
$collector = new Collector(array('country'));
$collector->addEntry(['country' => 'DE', 'counts'=>1]);
$collector->addEntry(['country' => 'DE', 'counts'=>2]);
$collector->addEntry(['country' => 'AT', 'counts'=>2]);
$collector->addEntry(['country' => 'AT', 'counts'=>3]);

$aggregationGroup = Aggregator::aggregate($collector);

$aggregateDE = $aggregationGroup->getEntryByKey('DE');
$aggregateAT = $aggregationGroup->getEntryByKey('AT');

print_r($aggregateDE->getData());
print_r($aggregateAT->getData());
```

```php
Array
(
    [country] => DE
    [counts] => 3
)
Array
(
    [country] => AT
    [counts] => 5
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