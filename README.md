# Input Collection

## Usage
Collections are filled by being passed through the Collector with an array of data, this usually come from your request. See more about [Collections](#collections). If any of the values in the collection fail validaton, a `CollectionValidationException` is thrown otherwise a filled instance of the collection is returned and deemed valid.

```php
use App\Http\InputCollections\CreateUser;
use InputCollection\Collector;
use InputCollection\Exceptions\CollectionValidationException;

$requestData = [
	'name' => 'Joe Bloggs',
	'age'  => '20',
];

try {
	$collection = Collector::collect(new CreateUser, $requestData);
} (CollectionValidationException $e) {
	// Handle exception
}

$name = $collection->getName();
$email = $collection->getAge();
```

## Collections
Collections are definitions of expected payloads. Each collection must define a set of expected inputs and how to validate those inputs upon collection. Every defined input **must** have a protected property with the same name on the collection, faliure to do this will result in an exception when the collection is instantiated. You can define inputs in 3 seperate arrays, `required`, `requireOne` or `optional`.

Once a collection has been run through the collector, if no exception was thrown, your collection is deemed valid and can safely be passed around your application using the defined getters to access the data.

```php
namespace App\Http\InputCollections;

use InputCollection\Collection;
use InputCollection\Values\Email;
use InputCollection\Values\Text;

class CreateUser extends Collection
{
	/** @var string */
	protected $name;

	/** @var int */
	protected $age;

	protected $required = [
		'name' => Text::class,
		'age'  => Number::class,
	];

	public function getName(): string
	{
		return $this->name;
	}

	public function getAge(): int
	{
		return $this->age;
	}
}
```

## Values
Values are definitions designed to validate the incomming data. If a value does not pass validiton, it will throw a `CollectionInputValueException`. 

### Custom values
You can create your own custom values to cover bespoke use cases. Each value must carry out it's validation in the `__construct` method, must implement `\InputCollection\Contracts\Value` and must throw a `CollectionInputValueException` when the value is deemed invalid.
