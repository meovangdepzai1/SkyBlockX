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
			$visitText = "OFF";
		} else {
			$visitText = "ON";
		}

		if ($lock == "OFF") {
			$lockText = "OFF";
		} else {
			$lockText = "ON";
		}
		parent::__construct(
			"Island",
			"",
			[
				new MenuOption("Island Teleport"),
				new MenuOption("Island Player Kick"),
				new MenuOption("Island Lock " . $lockText),
				new MenuOption("Island Visit Open Players"),
				new MenuOption("Island Visit " . $visitText),
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
					$player->sendForm(new IslandVisitOpenPlayersForm($player));
				}
				if ($dataOption === 4) {
                    			IslandManager::changeIslandVisit($player);
				}
				if ($dataOption === 5) {
					$player->sendForm(new IslandPartnerMainForm());
				}
				if ($dataOption === 6) {
					$player->sendForm(new IslandPointsForm());
				}
				if ($dataOption === 7) {
					$player->sendForm(new IslandDeleteRequireForm($player));
				}
			}
		);
	}

}
