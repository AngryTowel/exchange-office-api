<?php

namespace App\DTO\Interfaces;

interface DTOInterface
{
    /**
     * Create a new instance of the DTO from an array.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static;

    /**
     * Convert the DTO to an array.
     *
     * @return array
     */
    public function toArray(): array;
}
