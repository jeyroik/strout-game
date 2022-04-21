<?php
namespace stroug\interfaces\extensions;

interface IExtensionPlayerHealth
{
    public const PARAM__HEALTH = 'health';

    public function getHealth(): int;
    public function incHealth(int $amount): int;
    public function decHealth(int $amount): int;
    public function isDead(): bool;
    public function isAlive(): bool;
}
