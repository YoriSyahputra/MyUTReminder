<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Facades\Crypt;

class Encrypted implements CastsAttributes
{
	/**
	 * Cast the given value when retrieving from storage.
	 */
	public function get($model, string $key, $value, array $attributes)
	{
		if (is_null($value)) {
			return null;
		}

		try {
			return Crypt::decryptString($value);
		} catch (\Throwable $e) {
			// If decrypt fails, return the raw value to avoid breaking reads.
			return $value;
		}
	}

	/**
	 * Prepare the given value for storage.
	 */
	public function set($model, string $key, $value, array $attributes)
	{
		if (is_null($value)) {
			return [$key => null];
		}

		return [$key => Crypt::encryptString($value)];
	}
}
