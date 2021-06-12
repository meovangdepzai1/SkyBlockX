<?php


namespace skyblock\form;


use pocketmine\form\MenuForm;
use pocketmine\Player;
use skyblock\SkyBlock;

class IslandPointsForm extends MenuForm
{

	public function __construct()
	{
		$list = "";
		$list .= "\n";
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM islandLevel ORDER BY blockPlace DESC LIMIT 10;");
		$t = 0;
		while ($array = $database->fetchArray(SQLITE3_ASSOC)) {
			$table = $t + 1;
			$dbPlayer = $array['player'];
			$dbPoints = $array['blockPlace'];
			if($table == 1) {
				$list .= "§7[$table] > " . "§a$dbPlayer " . "§7- §e$dbPoints Points\n";
			}
			if($table == 2) {
				$list .= "§7[$table] > " . "§a$dbPlayer " . "§7- §e$dbPoints Points\n";
			}
			if($table == 3) {
				$list .= "§7[$table] > " . "§a$dbPlayer " . "§7- §e$dbPoints Points\n";
			}
			if($table > 3) {
				$list .= "§7[$table] > " . "§a$dbPlayer " . "§7- §e$dbPoints Points\n";
			}
			$t = $t + 1;
		}
		parent::__construct(
			"Island Points",
			"$list",
			[],
			function (Player $player, int $dataOption): void {

			}
		);
	}

}