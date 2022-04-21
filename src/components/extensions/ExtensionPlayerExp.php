<?php
namespace stroug\components\extensions;

use extas\components\extensions\Extension;
use extas\interfaces\samples\parameters\ISampleParameter;
use stroug\interfaces\extensions\IExtensionPlayerExp;
use stroug\interfaces\contracts\IContractPlayer;

class ExtensionPlayerExp extends Extension implements IExtensionPlayerExp
{
    public function getExp(IContractPlayer &$player = null): int
    {
        return (int) $player->getParameterValue(static::PARAM__EXPERIENCE, 0);
    }

    public function incExp(int $amount, IContractPlayer &$player = null): int
    {
        $this->setHealth($this->getExp($player) + $amount, $player);

        return $this->getExp($player);
    }

    public function decExp(int $amount, IContractPlayer &$player = null): int
    {
        return $this->incExp(-$amount, $player);
    }

    protected function setExp(int $amount, IContractPlayer &$player = null): IExtensionPlayerExp
    {
        if (!$player->hasParameter(static::PARAM__EXPERIENCE)) {
            $player->setParameter(static::PARAM__EXPERIENCE, [
                ISampleParameter::FIELD__VALUE => $amount,
                ISampleParameter::FIELD__NAME => static::PARAM__EXPERIENCE,
                ISampleParameter::FIELD__TITLE => 'Exp',
                ISampleParameter::FIELD__DESCRIPTION => 'Experience'
            ]);
        } else {
            $player->setParameterValue(static::PARAM__EXPERIENCE, $amount);
        }

        return $this;
    }
}
