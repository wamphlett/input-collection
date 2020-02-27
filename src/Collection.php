<?php

namespace InputCollection;

use InputCollection\Contracts\Collection as CollectionContract;
use InputCollection\Contracts\Value;

abstract class Collection implements CollectionContract
{
	protected $required = null;
	protected $requireOne = null;
	protected $optional = null;

	/**
	 * @var array
	 */
	private $data = [];

	/**
	 * @throws \Exception
	 */
	final public function __construct()
	{
		$this->validateInputObject();
	}

	/**
	 * @inheritDoc
	 */
	final public function set(string $field, $value): void
	{
		$inputs = $this->getAllInputs();
		if (array_key_exists($field, $inputs)) {
			$options = [];
			if (is_array($inputs[$field])) {
				$input = $inputs[$field][0];
				$options = $inputs[$field][1];
			} else {
				$input = $inputs[$field];
			}

			/** @var Value $validatedInput */
			$validatedInput = new $input($value, $options);
			$this->{$field} = $this->data[$field] = $validatedInput->getValue();
		}
	}

	/**
	 * @inheritDoc
	 */
	final public function has(string $key): bool
	{
		return array_key_exists($key, $this->data);
	}

	/**
	 * @inheritDoc
	 */
	final public function getAllInputs(): array
	{
		$requiredInputs = $this->getRequiredInputs();
		$requireOneInputs = $this->getRequireOneInputs();
		$optionalInputs = $this->getOptionalInputs();

		return array_merge($requiredInputs, $requireOneInputs, $optionalInputs);
	}

	/**
	 * @inheritDoc
	 */
	final public function getRequiredInputs(): array
	{
		return $this->required ?? [];
	}

	/**
	 * @inheritDoc
	 */
	final public function getRequireOneInputs(): array
	{
		return $this->requireOne ?? [];
	}

	/**
	 * @return array
	 */
	final public function getOptionalInputs(): array
	{
		return $this->optional ?? [];
	}

	/**
	 * This function looks at the collection and ensures that it has been created correctly
	 *
	 * @throws \Exception
	 */
	final private function validateInputObject(): void
	{
		$missing = [];
		$inputs = $this->getAllInputs();
		foreach ($inputs as $k => $v) {
			if (!property_exists($this, $k)) {
				$missing[] = $k;
			}
		}

		if (!empty($missing)) {
			throw new \Exception('Invalid input object ' . get_class($this)
				. '. Class did set input properties: ' . implode(', ', $missing));
		}
	}
}
