<?php


namespace skyblock\form;


use skyblock\IslandManager;
use skyblock\SkyBlock;

use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;

class IslandMainForm extends MenuForm
{

	public function __construct(Player $player)
	{
		$name = $player->getName();
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$name';");
		$database = $database->fetchArray(SQLITE3_ASSOC);
		$visit = $database['visit'];
		$lock = $database['lock'];
		if ($visit == "OFF") {
			$visitText = "§cOFF";
		} else {
			$visitText = "§aON";
		}
		if ($lock == "OFF") {
			$lockText = "§cOFF";
		} else {
			$lockText = "§aON";
		}
		parent::__construct(
			"Island",
			"",
			[
				new MenuOption("Island Teleport"),
				new MenuOption("Island Player Kick"),
				new MenuOption("Island Lock " . $lockText),
				new MenuOption("Island Visit " . $visitText),
				new MenuOption("Island Visit Open Players"),
				new MenuOption("Island Partner"),
				new MenuOption("Island Points"),
				new MenuOption("Island Delete")
			],
			function (Player $player, int $dataOption): void {
				if ($dataOption === 0) {
					IslandManager::islandTeleport($player);
				}
				if ($dataOption === 1) {
					$player->sendForm(new IslandPlayerKickForm($player));
				}
				if ($dataOption === 2) {
					IslandManager::changeIslandLock($player);
				}
				if ($dataOption === 3) {
					IslandManager::changeIslandVisit($player);
				}
				if ($dataOption === 4) {
					$player->sendForm(new IslandVisitOpenPlayersForm($player));
				}
				if ($dataOption === 5) {
					$player->sendForm(new IslandPartnerMainForm($player));
				}
				if ($dataOption === 6) {
					$player->sendForm(new IslandPointsForm($player));
				}
				if ($dataOption === 7) {
					$player->sendForm(new IslandDeleteRequireForm($player));
				}
			}
		);
	}

}