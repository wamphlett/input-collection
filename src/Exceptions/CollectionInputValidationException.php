<?php

namespace InputCollection\Exceptions;


class CollectionInputValidationException
{
	private $input;
	private $type;
	private $message;

	const TYPE_REQUIRED     = 'required';
	const TYPE_ONE_REQUIRED = 'oneRequired';

	/**
	 * @param string $input
	 * @param string $type
	 * @param string|null $message
	 */
	public function __construct(string $input, string $type, string $message = null)
	{
		$this->input = $input;
		$this->type = $type;
		$this->message = $message;
	}

	/**
	 * @return string
	 */
	public function getInput(): string
	{
		return $this->input;
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return string
	 */
	public function getMessage(): string
	{
		return $this->message;
	}

	/**
	 * @param string $input
	 *
	 * @return CollectionInputValidationException
	 */
	public static function required(string $input): CollectionInputValidationException
	{
		return new self($input, self::TYPE_REQUIRED, 'Missing required field');
	}

	/**
	 * @param string $inputs
	 *
	 * @return CollectionInputValidationException
	 */
	public static function oneRequired(string $inputs): CollectionInputValidationException
	{
		return new self($inputs, self::TYPE_ONE_REQUIRED, 'Missing required fields, at least one required');
	}
}
