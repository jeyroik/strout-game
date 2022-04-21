# strout-game
Game base package, powered by stressedout core

```php
$p1Sample = new ContractPlayerSample([...]);
$p2Sample = new ContractPlayerSample([...]);

$p1 = $space->createContract($p1Sample);
$p2 = $space->createContract($p2Sample);

$carSample = new ContractAssetSample([...]);
$carSample->setOwnerId($p1->getId());

$car = $space->createContract($carSample);

$transactionSample = $p1->sell($car, 100, $p2);
$space->createTransaction($transactionSample);
```