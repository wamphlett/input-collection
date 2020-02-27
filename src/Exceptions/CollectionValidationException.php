<?php

namespace InputCollection\Exceptions;

use InputCollection\Exceptions\CollectionInputValidationException;

class CollectionValidationException extends \Exception
{
	/**
	 * @var array
	 */
	private $errors = [];

	/**
	 * CollectionValidationException constructor.
	 *
	 * @param array $errors
	 * @param null $message
	 * @param null $code
	 * @param \Exception|null $previous
	 *
	 * @throws \Exception
	 */
	public function __construct(array $errors, $message = null, $code = null, \Exception $previous = null)
	{
		foreach ($errors as $error) {
			if (!($error instanceof CollectionInputValidationException)) {
				throw new \Exception('CollectionValidationException expects all errors to be an instance '
					. 'of CollectionInputValidationException');
			}
		}

		$this->errors = $errors;
		parent::__construct($message, $code, $previous);
	}

	/**
	 * @param callable|null $mapper
	 *
	 * @return array
	 */
	public function getErrors(callable $mapper = null): array
	{
		if ($mapper && is_callable($mapper)) {

			return array_map($mapper, $this->errors);
		}

		return $this->errors;
	}

	/**
	 * Returns the errors in an array to give to the response
	 *
	 * @return array
	 */
	public function toArray(): array
	{
		$response = [
			'message' => 'Input validation errors',
			'errors' => []
		];

		foreach ($this->errors as $error) {
			$response['errors'][$error->getInput()][] = $error->getMessage();
		}

		return $response;
	}
}
