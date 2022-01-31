<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Builders;

trait EntityBuilderTrait
{
    public function build()
    {
        $entity = new parent();
        foreach (get_object_vars($this) as $key => $value) {
            $entity->{$key} = $this->{$key};
        }

        return $entity;
    }
}
