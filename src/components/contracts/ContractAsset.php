<?php
namespace stroug\components\contracts;

abstract class ContractAsset extends Contract implements IContractAsset
{
    public function getOwnerId(): IContractPlayer
    {
        return $this->getParameterValue(static::PARAM__OWNER_ID, '');
    }
    public function setOwnerId(string $uuid): IContractAsset
    {
        $this->setParameterValue(static::PARAM__OWNER_ID, $uuid);

        return $this;
    }

    public function getPrice(): int
    {
        return $this->getParameterValue(static::PARAM__PRICE, 0);
    }

    public function setPrice(int $amount): IContractAsset
    {
        if (!$player->hasParameter(static::PARAM__PRICE)) {
            $player->setParameter(static::PARAM__PRICE, [
                ISampleParameter::FIELD__VALUE => $amount,
                ISampleParameter::FIELD__NAME => static::PARAM__PRICE,
                ISampleParameter::FIELD__TITLE => 'Price',
                ISampleParameter::FIELD__DESCRIPTION => 'Price'
            ]);
        } else {
            $player->setParameterValue(static::PARAM__PRICE, $amount);
        }
    }

    public function incPrice(int $amount): int
    {
        $this->setHealth($this->getPrice() + $amount);

        return $this->getPrice();
    }

    public function decPrice(int $amount): int
    {
        return $this->incPrice(-$amount);
    }

    protected function getSubjectForExtension(): string
    {
        return static::STROUG__SUBJECT;
    }
}
