<?php

namespace InputCollection\Exceptions;

class CollectionInputValueException extends \Exception
{
	const TYPE_TYPE = 'type';
	const TYPE_REQUIRED = 'required';
	const TYPE_INVALID = 'invalid';
	const TYPE_OPTION = 'option';

	/**
	 * @var string
	 */
	private $type;

	/**
	 * InputValueException constructor.
	 *
	 * @param string $message
	 * @param string $type
	 * @param int|null $code
	 * @param \Exception|null $previous
	 */
	public function __construct(string $message, string $type, int $code = null, \Exception $previous = null)
	{
		$this->type = $type;
		parent::__construct(
			$message,
			$code,
			$previous
		);
	}

	/**
	 * @return string
	 */
	public function getType(): string
	{
		return $this->type;
	}

	/**
	 * @return CollectionInputValueException
	 */
	public static function required(): CollectionInputValueException
	{
		return new self("Missing required input", self::TYPE_REQUIRED);
	}

	/**
	 * @param null $property
	 * @param string|null $expecting
	 *
	 * @return CollectionInputValueException
	 */
	public static function type($property = null, string $expecting = null): CollectionInputValueException
	{
		$message = "Incorrect type";
		if ($property) {
			$message .= sprintf("; Got \"%s\"", gettype($property));
		}
		if ($expecting) {
			$message .= sprintf(", expecting \"%s\"", $expecting);
		}

		return new self($message, self::TYPE_TYPE);
	}

	/**
	 * @return CollectionInputValueException
	 */
	public static function invalid(): CollectionInputValueException
	{
		return new self("Invalid format", self::TYPE_INVALID);
	}

	/**
	 * @param            $option
	 * @param array|null $options
	 *
	 * @return CollectionInputValueException
	 */
	public static function invalidOption($option, array $options = null): CollectionInputValueException
	{
		$message = 'Invalid option';
		if ($option) {
			$message .= ": $option";
		}
		if ($options) {
			$message .= '. available options [' . implode(', ', $options) . ']';
		}

		return new self($message, self::TYPE_OPTION);
	}
}
