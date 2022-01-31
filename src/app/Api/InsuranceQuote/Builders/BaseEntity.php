<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Builders;

class BaseEntity
{
    public function asArray(): array
    {
        $fields = array_filter(get_object_vars($this), function ($value) {
            return !is_null($value);
        });

        foreach ($fields as &$field) {
            if (is_object($field)) {
                $field = $field->asArray();
            }
        }

        return $fields;
    }
}
