<?php

namespace App\Contracts;

interface IsDto
{
    public function toArray(): array;
}