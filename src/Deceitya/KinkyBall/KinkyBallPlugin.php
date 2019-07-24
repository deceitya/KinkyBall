<?php

namespace Deceitya\KinkyBall;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\entity\Entity;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\item\ItemIds;

class KinkyBallPlugin extends PluginBase implements Listener
{
    public function onLoad()
    {
        Entity::registerEntity(KinkyBall::class, false, ['KinkyBall', 'minecraft:kinky_ball']);
    }

    public function onEnable()
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onHold(PlayerInteractEvent $event)
    {
        if ($event->getAction() == PlayerInteractEvent::RIGHT_CLICK_AIR) {
            if ($event->getItem()->getId() == ItemIds::BLAZE_ROD) {
                $player = $event->getPlayer();

                $entity = Entity::createEntity(
                    'KinkyBall',
                    $player->getLevel(),
                    Entity::createBaseNBT($player->add($player->getDirectionVector())->add(0, $player->getEyeHeight()))
                );
                if ($entity instanceof KinkyBall) {
                    foreach ($player->getLevel()->getPlayers() as $p) {
                        if ($player != $p) {
                            $entity->setTarget($p);
                        }
                    }
                }
                $entity->spawnToAll();
            }
        }
    }
}
