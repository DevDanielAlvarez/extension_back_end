<?php

namespace App\Services;


use Alvarez\ConcreteDto\Contracts\IsDTO;
use App\Dto\UserDto;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

/**
 * Abstract class to handle models working as service layer
 */
abstract class ModelService
{
    /**
     * Record of database
     * @var Model
     */
    protected Model $record;

    /**
     * Set Record
     * @param Model $record
     */
    public function __construct(Model $record)
    {
        $this->setRecord($record);
    }

    /**
     * Create a new record using a DTO or an array
     * @param array|IsDTO $data
     * @return ModelService
     */
    public static function create(array|IsDTO $data): static
    {
        if ($data instanceof IsDTO) {
            return new static(self::getModelPath()::create($data->toArray()));
        }
        return new static(self::getModelPath()::create($data));
    }

    /**
     * Find a record using id
     * @param string $id
     * @return ModelService
     */
    public static function find(string $id): static
    {
        return new static(self::getModelPath()::findOrFail($id));
    }

    public function update(array|IsDTO $data): static
    {
        if ($data instanceof IsDTO) {
            $this->getRecord()->update($data->toArray());
            return $this;
        }
        //update with array
        $this->getRecord()->update($data);
        return $this;
    }

    public function delete(): void
    {
        $this->record->delete();
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