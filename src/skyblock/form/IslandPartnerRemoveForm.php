<?php


namespace skyblock\form;


use skyblock\SkyBlock;

use pocketmine\form\CustomForm;
use pocketmine\form\CustomFormResponse;
use pocketmine\form\element\Input;
use pocketmine\Player;
use pocketmine\Server;

class IslandPartnerRemoveForm extends CustomForm
{

	public function __construct(Player $player)
	{
		parent::__construct(
			"Partner Remove",
			[
				new Input("element0", "Player Name", "Revenge8516")
			],
			function (Player $player, CustomFormResponse $response): void {
				$name = $response->getString("element0");
				$partner = Server::getInstance()->getPlayerExact($name);
				if ($partner instanceof Player) {
					if ($partner->getName() == $player->getName()) {
						$player->getName(SkyBlock::PREFIX . "§cYou can not remove yourself!");
						return;
					}
					$partnerName = $partner->getName();
					$islandName = $player->getName();
					$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$partnerName' AND partnerIslandName = '$islandName';");
					if (!empty($database->fetchArray(SQLITE3_ASSOC))) {
						SkyBlock::getInstance()->sqlite->query("DELETE FROM partner WHERE player = '$partnerName' AND partnerIslandName = '$islandName';");
						$player->sendMessage(SkyBlock::PREFIX . "§aYou removed §e" . $partner->getName() . " §ain your partner list");
					} else {
						$player->sendMessage(SkyBlock::PREFIX . "§e" . $partner->getName() . " §cis not your partner");
					}
				}
			}
		);
	}

}