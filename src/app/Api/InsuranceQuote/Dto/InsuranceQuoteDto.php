<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Dto;

use Illuminate\Support\Arr;

final class InsuranceQuoteDto
{
    /** @var array $items */
    private $items
        = [
            'age',
            'dependents',
            'income',
            'marital_status',
            'risk_questions',
            'ownership_status',
            'vehicle_year',
        ];

    /**
     * Populate a dto receiving an array as a param.
     *
     * @param array $payload
     * @return self
     */
    public static function fromArray(array $payload): self
    {
        return (new static)->populateFromArray($payload);
    }

    /** getters */
    public function getAge(): int
    {
        return $this->items['age'];
    }

    public function getDependents(): int
    {
        return $this->items['dependents'];
    }

    public function getIncome(): int
    {
        return $this->items['income'];
    }

    public function getMaritalStatus(): string
    {
        return $this->items['marital_status'];
    }

    public function getRiskQuestions(): array
    {
        return $this->items['risk_questions'];
    }

    public function getOwnershipStatus(): ?string
    {
        if (!$this->items['house']) {
            return null;
        }

        return Arr::get($this->items, 'house.ownership_status');
    }

    public function getVehicleYear(): ?int
    {
        if (!$this->items['vehicle']) {
            return null;
        }

        return Arr::get($this->items, 'vehicle.year');
    }

    private function populateFromArray(array $payload): self
    {
        $this->items = collect($payload)
            ->filter(function ($value) {
                return !in_array($value, [null, ''], true);
            })
            ->map(function ($value) {
                return $this->filterValue($value);
            })->all();

        return $this;
    }

    private function filterValue($value)
    {
        switch (gettype($value)) {
            case 'boolean':
                return boolval($value);
            
            case 'string':
                return trim(filter_var($value, FILTER_SANITIZE_STRING));

            case 'integer':
                return intval($value);
            
            default:
                return $value;
        }
    }
}
