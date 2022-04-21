<?php
namespace stroug\interfaces\contracts;

use strout\interfaces\foundation\contracts\IContract;
use strout\interfaces\foundation\transactions\ITransactionSample;

interface IContractPlayer extends IContract
{
    public const STROUG__SUBJECT = 'stroug.contract.player';

    public const PARAM__ASSETS = 'assets';

    public function own(IContractAsset $asset): IContractPlayer;

    public function sell(IContractAsset $subject, IContractPlayer $to): ITransactionSample;

    public function buy(IContractAsset $subject, IContractPlayer $from): ITransactionSample;

    /**
     * @return IContractAsset[]
     */
    public function getAssets(): array;

    public function getAsset(string $id): ?IContractAsset;
}
