<?php

namespace App\Dto;

use Alvarez\ConcreteDto\AbstractDTO;


class UserDto extends AbstractDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $registration_number,
        public readonly string $password
    ) {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'registration_number' => $this->registration_number,
            'password' => $this->password
        ];
    }

}