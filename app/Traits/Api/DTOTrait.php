<?php

namespace App\Traits\Api;

use App\DTO\Interfaces\DTOInterface;

/**
 * @mixin DTOInterface
 */
trait DTOTrait
{
    public static function fromArray(array $data): static
    {
        $instance = new static();
        $filteredData = array_intersect_key($data, get_class_vars(static::class));
        foreach ($filteredData as $property => $value) {
            $instance->$property = $value;
        }
        return $instance;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
