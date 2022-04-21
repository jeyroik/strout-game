<?php
namespace stroug\components\extensions;

use extas\components\extensions\Extension;
use extas\interfaces\samples\parameters\ISampleParameter;
use stroug\interfaces\extensions\IExtensionPlayerHealth;
use stroug\interfaces\contracts\IContractPlayer;

class ExtensionPlayerHealth extends Extension implements IExtensionPlayerHealth
{
    public function getHealth(IContractPlayer &$player = null): int
    {
        return (int) $player->getParameterValue(static::PARAM__HEALTH, 0);
    }

    public function incHealth(int $amount, IContractPlayer &$player = null): int
    {
        $this->setHealth($this->getHealth($player) + $amount, $player);

        return $this->getHealth($player);
    }

    public function decHealth(int $amount, IContractPlayer &$player = null): int
    {
        return $this->incHealth(-$amount, $player);
    }

    public function isDead(IContractPlayer &$player = null): bool
    {
        return !$this->isAlive($player);
    }

    public function isAlive(IContractPlayer &$player = null): bool
    {
        return (bool) $this->getHealth($player);
    }

    protected function setHealth(int $amount, IContractPlayer &$player = null): IExtensionPlayerHealth
    {
        if (!$player->hasParameter(static::PARAM__HEALTH)) {
            $player->setParameter(static::PARAM__HEALTH, [
                ISampleParameter::FIELD__VALUE => $amount,
                ISampleParameter::FIELD__NAME => static::PARAM__HEALTH,
                ISampleParameter::FIELD__TITLE => 'HP',
                ISampleParameter::FIELD__DESCRIPTION => 'Health points'
            ]);
        } else {
            $player->setParameterValue(static::PARAM__HEALTH, $amount);
        }

        return $this;
    }
}
