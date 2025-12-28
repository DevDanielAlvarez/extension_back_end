<?php

namespace App\Dto;

use App\Contracts\IsDto;


class UserDto implements IsDto
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