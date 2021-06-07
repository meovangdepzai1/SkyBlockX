<?php


namespace skyblock\form;


use skyblock\IslandManager;
use skyblock\SkyBlock;

use pocketmine\form\MenuOption;
use pocketmine\form\MenuForm;
use pocketmine\Player;

class IslandVisitOpenPlayersForm extends MenuForm
{

	public function __construct(Player $player)
	{
		$options = [];
		$result = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock");
		$i = -1;
		while ($array = $result->fetchArray(SQLITE3_ASSOC)) {
			$j = $i + 1;
			$visit = $array['visit'];
			$player = $array['player'];
			if($visit === "ON") {
				$options[] = new MenuOption("$player");
				$i = $i + 1;
			}
		}
		parent::__construct(
			"Island Visit Open Players",
			"",
			$options,
			function (Player $player, int $dataOption): void {
				$selectedPlayer = $this->getOption($dataOption)->getText();
				IslandManager::islandVisit($player, $selectedPlayer);
			}
		);
	}

}