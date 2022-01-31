<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Interfaces;

interface EntityBuilderInterface
{
    public static function builder();

    public function asArray(): array;
}
