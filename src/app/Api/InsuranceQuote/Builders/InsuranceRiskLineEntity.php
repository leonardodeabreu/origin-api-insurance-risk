<?php declare(strict_types = 1);

namespace App\Api\InsuranceQuote\Builders;

use App\Api\InsuranceQuote\Interfaces\EntityBuilderInterface;

class InsuranceRiskLineEntity extends BaseEntity implements EntityBuilderInterface
{
    /** @var AutoEntity $auto */
    protected $auto;

    /** @var LifeEntity $life */
    protected $life;

    /** @var DisabilityEntity $disability */
    protected $disability;

    /** @var HomeEntity $home */
    protected $home;

    public static function builder(): InsuranceRiskLineEntityBuilder
    {
        return new InsuranceRiskLineEntityBuilder();
    }

    public function getAuto(): AutoEntity
    {
        return $this->auto;
    }

    public function getLife(): LifeEntity
    {
        return $this->life;
    }

    public function getDisability(): DisabilityEntity
    {
        return $this->disability;
    }

    public function getHome(): HomeEntity
    {
        return $this->home;
    }
}
