<?php
namespace stroug\interfaces\extensions;

interface IExtensionPlayerExp
{
    public const PARAM__EXPERIENCE = 'exp';

    public function getExp(): int;
    public function incExp(int $amount): int;
    public function decExp(int $amount): int;
}
