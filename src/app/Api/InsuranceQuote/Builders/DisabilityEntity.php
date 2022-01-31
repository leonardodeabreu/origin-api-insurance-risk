<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Interfaces\EntityBuilderInterface;

class DisabilityEntity extends BaseEntity implements EntityBuilderInterface
{
    /** @var boolean $eligible */
    protected $eligible = true;
    
    /** @var int $score */
    protected $score = 0;

    public static function builder(): DisabilityEntityBuilder
    {
        return new DisabilityEntityBuilder();
    }

    public function isEligible(): bool
    {
        return $this->eligible;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
