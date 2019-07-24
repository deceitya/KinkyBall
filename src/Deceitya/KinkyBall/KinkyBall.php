<?php

namespace Deceitya\KinkyBall;

use pocketmine\entity\projectile\Throwable;
use pocketmine\block\Block;
use pocketmine\math\RayTraceResult;
use pocketmine\Player;
use pocketmine\math\Vector3;

class KinkyBall extends Throwable
{
    public const NETWORK_ID = self::DRAGON_FIREBALL;

    /** @var Player */
    private $target = null;
    /** @var bool */
    private $flag = false;

    public function entityBaseTick(int $tickDiff = 1): bool
    {
        if ($this->closed) {
            return false;
        }

        $motion = $this->target != null ? $this->target->add(0, 1)->subtract($this)->normalize() : new Vector3(0, -$this->gravity, 0);

        if ($this->flag) {
            $this->teleport($this->add($motion));

            if (empty($this->getBlocksAround())) {
                $this->flag = false;
            }
        }

        $this->setMotion($motion);

        return true;
    }

    public function onHitBlock(Block $blockHit, RayTraceResult $hitResult): void
    {
        if (!$this->flag) {
            $this->flag = true;
        }
    }

    public function setTarget(Player $player)
    {
        $this->target = $player;
    }
}
