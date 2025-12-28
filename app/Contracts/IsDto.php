<?php

namespace App\Contracts;

interface IsDTO
{
    public function toArray(): array;
}