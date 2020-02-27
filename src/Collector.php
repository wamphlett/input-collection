<?php

namespace InputCollection;

use InputCollection\Contracts\Collection as CollectionContract;
use InputCollection\Exceptions\CollectionInputValidationException;
use InputCollection\Exceptions\CollectionInputValueException;
use InputCollection\Exceptions\CollectionValidationException;

class Collector
{
	/**
	 * @param CollectionContract $collection
	 * @param array              $data
	 *
	 * @return CollectionContract
	 * @throws CollectionValidationException
	 * @throws \Exception
	 */
	public static function collect(CollectionContract $collection, array $data = []): CollectionContract
	{
		$errors = [];
		$missingInputs = [];
		foreach (array_keys($collection->getRequiredInputs()) as $inputName) {
			if (!array_key_exists($inputName, $data)) {
				$missingInputs[] = $inputName;
				$errors[] = CollectionInputValidationException::required($inputName);
			}
		}

		$requireOneInputs = array_keys($collection->getRequireOneInputs());
		if (!empty($requireOneInputs)) {
			$satisfied = false;
			foreach ($requireOneInputs as $inputName) {
				if (array_key_exists($inputName, $data)) {
					$satisfied = true;
					break;
				}
			}
			if (!$satisfied) {
				$errors[] = CollectionInputValidationException::oneRequired(implode(', ', $requireOneInputs));
			}
		}

		foreach (array_keys($collection->getAllInputs()) as $inputName) {
			if (in_array($inputName, $missingInputs) || !array_key_exists($inputName, $data)) {
				continue;
			}
			try {
				$collection->set($inputName, $data[$inputName]);
			} catch (CollectionInputValueException $e) {
				$errors[] = new CollectionInputValidationException($inputName, $e->getType(), $e->getMessage());
			} catch (\Exception $e) {
				$errors[] = new CollectionInputValidationException($inputName, 'unknown', $e->getMessage());
			}
		}

		if (!empty($errors)) {
			throw new CollectionValidationException($errors);
		}

		return $collection;
	}
}
