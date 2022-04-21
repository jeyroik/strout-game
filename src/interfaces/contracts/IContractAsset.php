<?php
namespace stroug\interfaces\contracts;

use strout\interfaces\foundation\contracts\IContract;

interface IContractAsset extends IContract
{
    public const STROUG__SUBJECT = 'stroug.contract.asset';

    public const PARAM__OWNER_ID = 'owner_id';
    public const PARAM__PRICE = 'price';

    public function applyToPlayer(IContractPlayer $player): IContractAsset;
    public function applyToAsset(IContractAsset $asset): IContractAsset;

    public function getOwnerId(): IContractPlayer;
    public function setOwnerId(string $uuid): IContractAsset;

    public function getPrice(): int;
    public function setPrice(int $amount): IContractAsset;
    public function incPrice(int $amount): int;
    public function decPrice(int $amount): int;
}
