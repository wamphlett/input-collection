<?php

namespace InputCollection\Contracts;

use InputCollection\Exceptions\CollectionInputValueException;

interface Collection
{
	/**
	 * @param string $field
	 * @param        $value
	 *
	 * @throws CollectionInputValueException
	 */
	public function set(string $field, $value): void;

	/**
	 * Returns true if the given key has been set
	 *
	 * @param string $key
	 *
	 * @return bool
	 */
	public function has(string $key): bool;

	/**
	 * @return array
	 */
	public function getAllInputs(): array;

	/**
	 * @return array
	 */
	public function getRequiredInputs(): array;

	/**
	 * @return array
	 */
	public function getRequireOneInputs(): array;

	/**
	 * @return array
	 */
	public function getOptionalInputs(): array;
}
