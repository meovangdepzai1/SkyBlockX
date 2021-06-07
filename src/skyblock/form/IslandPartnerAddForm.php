<?php


namespace skyblock\form;


use skyblock\SkyBlock;

use pocketmine\form\CustomForm;
use pocketmine\form\CustomFormResponse;
use pocketmine\form\element\Input;
use pocketmine\Player;
use pocketmine\Server;

class IslandPartnerAddForm extends CustomForm
{

	public function __construct(Player $player)
	{
		parent::__construct(
			"Partner Add",
			[
				new Input("element0", "Player Name", "Revenge8516")
			],
			function (Player $player, CustomFormResponse $response): void {
				$name = $response->getString("element0");
				$partner = Server::getInstance()->getPlayerExact($name);
				if($partner instanceof Player) {
					if($partner->getName() == $player->getName()) {
						$player->sendMessage(SkyBlock::PREFIX . "§cYou can not add yourself!");
						return;
					}
					$partnerName = $partner->getName();
					$islandName = $player->getName();
					$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$partnerName' and partnerIslandName = '$islandName';");
					if(empty($database->fetchArray(SQLITE3_ASSOC))) {
						$player->sendMessage(SkyBlock::PREFIX . "§cAlready a partner");
						return;
					}
					$database = SkyBlock::getInstance()->sqlite->prepare("INSERT INTO partner (player, partnerIslandName) VALUES (:player, :partnerIslandName);");
					$database->bindValue(":player", $partner->getName());
					$database->bindValue(":partnerIslandName", $player->getName());
					$database->execute();
					$partner->sendMessage(SkyBlock::PREFIX . "§e" . $player->getName() . " §aadded you as partner");
					$player->sendMessage(SkyBlock::PREFIX . "§aYou added §e" . $partner->getName());
				}
			}
		);
	}

}