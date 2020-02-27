<?php

namespace InputCollection\Values;

use InputCollection\Exceptions\CollectionInputValueException;

class Text extends BaseValue
{
	/**
	 * Text constructor.
	 *
	 * @param $text
	 *
	 * @throws CollectionInputValueException
	 */
	public function __construct($text)
	{
		if (!is_string($text)) {
			throw CollectionInputValueException::type($text, 'string');
		}

		$this->value = $text;
	}
}
