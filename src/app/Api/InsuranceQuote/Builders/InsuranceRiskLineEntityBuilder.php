<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Interfaces\BuilderInterface;

class InsuranceRiskLineEntityBuilder extends InsuranceRiskLineEntity implements BuilderInterface
{
    use EntityBuilderTrait;

    public function setAuto(AutoEntityBuilder $auto): self
    {
        $this->auto = $auto->build();
        return $this;
    }

    public function setLife(LifeEntityBuilder $life): self
    {
        $this->life = $life->build();
        return $this;
    }

    public function setDisability(DisabilityEntityBuilder $disability): self
    {
        $this->disability = $disability->build();
        return $this;
    }

    public function setHome(HomeEntityBuilder $home): self
    {
        $this->home = $home->build();
        return $this;
    }
}
