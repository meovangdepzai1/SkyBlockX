<?php


namespace skyblock\form;


use skyblock\SkyBlock;

use pocketmine\level\Position;
use pocketmine\Server;
use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;

class IslandPartnerTeleportForm extends MenuForm
{

    /**
     * IslandPartnerTeleportForm constructor.
     * @param Player $player
     */
    public function __construct(Player $player)
	{
		$options = [];
		$result = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner");
		$i = -1;
		while ($array = $result->fetchArray(SQLITE3_ASSOC)) {
			$j = $i + 1;
			$player = $array['player'];
				$options[] = new MenuOption("$player");
				$i = $i + 1;
		}
		parent::__construct(
			"Partner Teleport",
			"",
			$options,
			function (Player $player, int $dataOption): void {
				$selectedPlayer = $this->getOption($dataOption)->getText();
				$name = $selectedPlayer;
				$partner = Server::getInstance()->getPlayerExact($name);
				if($partner instanceof Player) {
					if($partner->getName() == $player->getName()) {
						$player->sendMessage(SkyBlock::PREFIX . "§cYou can not visit yourself!");
						return;
					}
					$partnerName = $player->getName();
					$islandName = $partner->getName();
					$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$partnerName' AND partnerIslandName = '$islandName';");
					if(empty($database->fetchArray(SQLITE3_ASSOC))) {
						$player->sendMessage(SkyBlock::PREFIX . "§cHe should add you as a partner so you can visit his island");
						return;
					}
				}
				Server::getInstance()->loadLevel($selectedPlayer);
				$level = Server::getInstance()->getLevelByName($selectedPlayer);
				$player->teleport(new Position(3, 4, 5, $level));
			}
		);
	}

}