<?php

namespace App\Services;

use App\Contracts\IsDTO;
use App\Dto\UserDto;
use Illuminate\Database\Eloquent\Model;

abstract class ModelService
{
    protected Model $record;

    public function __construct(Model $record)
    {
        $this->setRecord($record);
    }

    public static function create(array|IsDTO $dto)
    {
        self::getModelPath()::create($dto->toArray());
    }
    public function getRecord(): Model
    {
        return $this->record;
    }
    public function setRecord(Model $record): static
    {
        $this->record = $record;
        return $this;
    }
    public static function getModelPath(): string
    {
        $serviceClassName = class_basename(static::class);
        $modelName = str_replace('Service', '', $serviceClassName);
        return 'App\\Models\\' . $modelName;
    }
}