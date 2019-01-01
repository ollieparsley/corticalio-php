# PHP library for the cortical.io API

## Description

The official cortical.io PHP library is deprecated and no-longer maintained (https://github.com/cortical-io/php-client-sdk). So, since I needed to use the API with a PHP service, I decided to create this library so that others could use it.

## Links

* REST API documentation: https://www.cortical.io/resources_apidocumentation.html
* REST API console: https://api.cortical.io/
* Cortical.io website: https://cortical.io/

## Requirements
PHP >= `7.0`

## Usage

### Installation
Recommended technique is to use composer

```
composer require ollieparsley/corticalio
```

### Making requests

#### Retinas
```
$client = new \Corticalio\Client([
    'api_key' => 'MY_API_KEY',
]);

echo "List retinas: \n";
print_r($client->retinas->listRetinas());
echo "\n\n";

echo "Show retina en_associative: \n";
print_r($client->retinas->getRetina('en_associative'));
echo "\n\n";
```

#### Terms
```
$client = new \Corticalio\Client([
    'api_key' => 'MY_API_KEY',
]);

echo "List terms: \n";
print_r($client->terms->listTerms('en_associative'));
echo "\n\n";

echo "Show term soccer using en_associative: \n";
print_r($client->terms->getTerm('en_associative', 'soccer'));
echo "\n\n";

echo "Show term contexts for soccer using en_associative: \n";
print_r($client->terms->listTermContexts('en_associative', 'soccer'));
echo "\n\n";

echo "Show similar terms to soccer using en_associative: \n";
print_r($client->terms->listSimilarTerms('en_associative', 'soccer'));
echo "\n\n";
```

#### Compare
```
$client = new \Corticalio\Client([
    'api_key' => 'MY_API_KEY',
]);

echo "Compare 2 elements using en_associative: \n";
$element1 = new \Corticalio\Model\ExpressionElement();
$element1->text = 'Manchester City lost the football match';
$element2 = new \Corticalio\Model\ExpressionElement();
$element2->text = 'Manchester United won the football match';
print_r($client->compare->compare('en_associative', $element1, $element2));
echo "\n\n";

echo "Bulk compare element pairs en_associative: \n";
$elementPairs = new \Corticalio\Model\ExpressionElementArray();
$elementPairs->addPair($element1, $element2);
$elementPairs->addPair($element2, $element1);
print_r($client->compare->bulkCompare('en_associative', $elementPairs));
echo "\n\n";
```

### Exceptions

There is a generic `Corticalio\Exception` class that is extended for some specific reasons to use. Anything that does not throw from this base exception will most-likely be coming from a dependency such a Guzzle.

## API Sections

### Covered

These API sections are covered by the client library

* Retinas
* Terms 
* Compare

### Todo

These haven't been done yet. I do want to complete the library with these though

* Text
* Expression
* Image
* Classify

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/ollieparsley/corticalio-php/tags). 

## Authors

* **Ollie Parsley** - *All work so far!* - [Github](https://github.com/ollieparsley) | [Twitter](https://twitter.com/ollieparsley)

## Contributing

Please do contribute to this library. Please submit pull requests and I'll do my best to review them and merge if appropriate.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details



