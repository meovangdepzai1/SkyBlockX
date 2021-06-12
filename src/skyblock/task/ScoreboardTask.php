<?php


namespace skyblock\task;


use skyblock\api\ScoreboardAPI;
use skyblock\SkyBlock;

use onebone\economyapi\EconomyAPI;
use pocketmine\form\MenuOption;
use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
use pocketmine\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class ScoreboardTask extends Task
{

	/** @var SkyBlock */
	protected $plugin;

	public function __construct(SkyBlock $plugin)
	{
		$this->plugin = $plugin;
	}

	public function onRun(int $currentTick)
	{
		foreach (Server::getInstance()->getOnlinePlayers() as $player) {
			$this->sendBoard($player);
		}
	}

	public function sendBoard(Player $player){
		$packet = new RemoveObjectivePacket();
		$packet->objectiveName = "scoreboard";
		$player->sendDataPacket($packet);
		$this->boardFormat($player);
	}

	public static function boardFormat(Player $player){
		$money = EconomyAPI::getInstance()->myMoney($player);

		$name = $player->getName();
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM islandLevel WHERE player = '$name';");
		$array = $database->fetchArray(SQLITE3_ASSOC);

		ScoreboardAPI::title($player);
		ScoreboardAPI::line($player, "      ", 0);
		ScoreboardAPI::line($player, "§l§ePLAYER", 1);
		ScoreboardAPI::line($player, "                  ", 2);
		ScoreboardAPI::line($player, "§7Player: §a" . $player->getName(), 3);
		ScoreboardAPI::line($player, "§7Balance: §a" . $money, 4);
		ScoreboardAPI::line($player, "   ", 5);
		ScoreboardAPI::line($player, "§l§eISLAND", 6);
		ScoreboardAPI::line($player, "                    ", 7);
		ScoreboardAPI::line($player, "§7Island Points: §a" . $array["blockPlace"], 8);
		ScoreboardAPI::line($player, "              ", 9);
		ScoreboardAPI::line($player, "§aCode by Revenge8516", 10);
	}

}
