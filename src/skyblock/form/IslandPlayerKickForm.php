<?php


namespace skyblock\form;


use skyblock\SkyBlock;

use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;
use pocketmine\Server;

class IslandPlayerKickForm extends MenuForm
{

    /**
     * IslandPlayerKickForm constructor.
     * @param Player $player
     */
    public function __construct(Player $player)
	{
		$options = [];
		Server::getInstance()->loadLevel($player->getName());
		$level = Server::getInstance()->getLevelByName($player->getName());
		if ($level->getPlayers() != null) {
			foreach ($level->getPlayers() as $player) {
				$options[] = new MenuOption($player->getName());
			}
		}
		parent::__construct(
			"Island Player Kick",
			"",
			$options,
			function (Player $player, int $dataOption): void {
				Server::getInstance()->loadLevel($player->getName());
				foreach (Server::getInstance()->getLevelByName($player->getName())->getPlayers() as $sender) {
					$sender->teleport(Server::getInstance()->getDefaultLevel()->getSafeSpawn(), 0, 0);
					$sender->sendMessage(SkyBlock::PREFIX . "§e" . $player->getName() . " §aYou have been kicked off the player's island");
					$player->sendMessage(SkyBlock::PREFIX . "§e" . $sender->getName() . " §aPlayer kicked off the island");
				}
			}
		);
	}

}