<?php

namespace InputCollection\Values;

use InputCollection\Contracts\Value;

class BaseValue implements Value
{
	/**
	 * @var mixed
	 */
	protected $value;

	/**
	 * @inheritDoc
	 */
	public function getValue()
	{
		return $this->value;
	}
}
