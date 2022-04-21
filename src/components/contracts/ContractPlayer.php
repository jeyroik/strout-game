<?php
namespace stroug\components\contracts;

class ContractPlayer extends Contract implements IContractPlayer
{
    public function own(IContractAsset $asset): IContractPlayer
    {
        $asset->setOwnerId($this->getId());
        $this->addAsset($asset);

        return $this;
    }

    public function sell(IContractAsset $subject, IContractPlayer $to): IContractPlayer
    {
        if ($subject->getOwnerId() != $this->getId()) {
            throw new \Exception('Can not sell asset of another owner');
        }

        if ($to->getBalance() < $subject->getPrice()) {
            throw new \Exception('Buyer has not enough balance');
        }

        $to->own($subject);
        $this->removeAsset($subject->getId());

        $this->incBalance($subject->getPrice());
        $to->decBalance($subject->getPrice());

        return $this->createTransactionSample($this, $subject, $to);
    }

    public function buy(IContractAsset $subject, IContractPlayer $from): IContractPlayer
    {
        if ($subject->getOwnerId() != $from->getId()) {
            throw new \Exception('Can not sell asset of another owner');
        }

        if ($this->getBalance() < $subject->getPrice()) {
            throw new \Exception('You have not enough balance');
        }

        $this->own($subject);
        $from->removeAsset($subject->getId());

        $to->incBalance($subject->getPrice());
        $this->decBalance($subject->getPrice());

        return $this->createTransactionSample($to, $subject, $this);
    }

    /**
     * @return IContractAsset[]
     */
    public function getAssets(): array
    {
        return $this->getParameterValue(static::PARAM__ASSETS, []);
    }

    public function getAsset(string $id): ?IContractAsset
    {
        return $this->getAssets()[$id] ?? null;
    }

    protected function addAsset(IContractAsset $asset): IContractPlayer
    {
        $assets = $this->getAssets();
        $assets[$asset->getId()] = $asset;
        $this->setAssets($assets);

        return $this;
    }

    protected function removeAsset(string $id): IContractPlayer
    {
        $assets = $this->getAssets();

        if (isset($assets[$asset->getId()])) {
            unset($assets[$asset->getId()]);
        }

        $this->setAssets($assets);

        return $this;
    }

    protected function setAssets(array $assets): IContractPlayer
    {
        $this->setParameterValue(static::PARAM__ASSETS, $assets);

        return $this;
    }

    protected function createTransactionSample(IContractPlayer $from, IContractAsset $subject, IContractPlayer $to)
    {
        $transactionSample = new TransactionSample([
            TransactionSample::FIELD__CLASS => Transaction::class
        ]);
        $transactionSample->addParameters([
            new SampleParameter([
                SampleParameter::FIELD__NAME => ITransaction::FIELD__ID,
                SampleParameter::FIELD__TITLE => 'ID',
                SampleParameter::FIELD__DESCRIPTION => 'Identifier',
                SampleParameter::FIELD__VALUE =>''
            ]),
            new SampleParameter([
                SampleParameter::FIELD__NAME => ITransaction::FIELD__FROM,
                SampleParameter::FIELD__TITLE => 'From',
                SampleParameter::FIELD__DESCRIPTION => 'Previous owner',
                SampleParameter::FIELD__VALUE => $from->getId()
            ]),
            new SampleParameter([
                SampleParameter::FIELD__NAME => ITransaction::FIELD__TO,
                SampleParameter::FIELD__TITLE => 'To',
                SampleParameter::FIELD__DESCRIPTION => 'New owner',
                SampleParameter::FIELD__VALUE => $to->getId()
            ]),
            new SampleParameter([
                SampleParameter::FIELD__NAME => ITransaction::FIELD__AMOUNT,
                SampleParameter::FIELD__TITLE => 'Amount',
                SampleParameter::FIELD__DESCRIPTION => 'Amount',
                SampleParameter::FIELD__VALUE => $subject->getPrice()
            ]),
            new SampleParameter([
                SampleParameter::FIELD__NAME => ITransaction::FIELD__CREATED_AT,
                SampleParameter::FIELD__TITLE => 'Created at',
                SampleParameter::FIELD__DESCRIPTION => 'Time of transaction created',
                SampleParameter::FIELD__VALUE => time()
            ]),
            new SampleParameter([
                SampleParameter::FIELD__NAME => ITransaction::FIELD__PROVIDER_ID,
                SampleParameter::FIELD__TITLE => 'Provider',
                SampleParameter::FIELD__DESCRIPTION => 'Provider identifier',
                SampleParameter::FIELD__VALUE => ''
            ])
        ]);

        return $transactionSample;
    }

    protected function getSubjectForExtension(): string
    {
        return static::STROUG__SUBJECT;
    }
}
