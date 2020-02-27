<?php

namespace InputCollection\Values;

use InputCollection\Exceptions\CollectionInputValueException;

class Email extends BaseValue
{
	/**
	 * @param $email
	 *
	 * @throws CollectionInputValueException
	 */
	public function __construct($email)
	{
		if (!is_string($email)) {
			throw CollectionInputValueException::type($email, 'string');
		}

		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			throw CollectionInputValueException::invalid();
		}

		$this->value = $email;
	}
}
