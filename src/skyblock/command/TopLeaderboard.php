<?php


namespace skyblock\command;


use skyblock\SkyBlock;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\entity\Entity;
use pocketmine\level\Position;
use pocketmine\Server;

class TopLeaderboard extends Command
{

    public function __construct()
    {
        parent::__construct("topleaderboard","Top Island Leaderboard Create");
    }

    /**
     * @param CommandSender $player
     * @param string $commandLabel
     * @param array $args
     * @return mixed|void
     */
    public function execute(CommandSender $player, string $commandLabel, array $args)
    {
        if($player->hasPermission("topleaderboard.create.skyblockx")) {
            $level = Server::getInstance()->getLevelByName(SkyBlock::getInstance()->config->get("leaderboardworld"));
            $position = new Position($player->getX(), $player->getY() + 1.5, $player->getZ(), $level);
            $nbt = Entity::createBaseNBT($position, null, 1.0, 1.0);
            $create = Entity::createEntity("FloatingTextEntity", $level, $nbt);
            $create->spawnToAll();
        }
    }

}