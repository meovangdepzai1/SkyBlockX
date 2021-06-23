<?php


namespace skyblock\form;


use skyblock\IslandManager;
use skyblock\SkyBlock;

use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;

class IslandMainForm extends MenuForm
{

    /**
     * IslandMainForm constructor.
     * @param Player $player
     */
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
				new MenuOption("§l§a•§eTrở Về Đảo§a•"),
				new MenuOption("§l§a•§eĐá Người Chơi§a•"),
				new MenuOption("§l§a•§eKhoá Đảo " . $lockText. "§a•"),
				new MenuOption("§l§a•§eThêm Người Chơi§a•"),
                new MenuOption("§l§a•§eTham Gia Đảo Người Khác " . $visitText . "§a•"),
				new MenuOption("§l§a•§e Đối tác§a•"),
				new MenuOption("§l§a•§eTop Đảo§a•"),
				new MenuOption("§l§a•§eXóa Đảo§a•")
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
