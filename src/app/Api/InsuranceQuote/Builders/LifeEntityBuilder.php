<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Interfaces\BuilderInterface;

class LifeEntityBuilder extends LifeEntity implements BuilderInterface
{
    use EntityBuilderTrait;

    public function setEligible(bool $eligible): self
    {
        $this->eligible = $eligible;
        return $this;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;
        return $this;
    }
}
