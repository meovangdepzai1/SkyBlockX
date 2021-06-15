<?php


namespace skyblock\task;


use skyblock\api\ScoreboardAPI;
use skyblock\SkyBlock;

use onebone\economyapi\EconomyAPI;

use pocketmine\network\mcpe\protocol\RemoveObjectivePacket;
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

			$packet = new RemoveObjectivePacket();
			$packet->objectiveName = "scoreboard";
			$player->sendDataPacket($packet);

			$money = EconomyAPI::getInstance()->myMoney($player);

			$name = $player->getName();
			$database = SkyBlock::getInstance()->toplevel->query("SELECT * FROM islandLevel");
			$database = $database->fetchArray(SQLITE3_ASSOC);
			$blockPlace = $database['blockPlace'];

			ScoreboardAPI::title($player);
			ScoreboardAPI::line($player, "      ", 0);
			ScoreboardAPI::line($player, "§l§ePLAYER", 1);
			ScoreboardAPI::line($player, "                  ", 2);
			ScoreboardAPI::line($player, "§7Player: §a" . $player->getName(), 3);
			ScoreboardAPI::line($player, "§7Balance: §a" . $money, 4);
			ScoreboardAPI::line($player, "   ", 5);
			ScoreboardAPI::line($player, "§l§eISLAND", 6);
			ScoreboardAPI::line($player, "                    ", 7);
			ScoreboardAPI::line($player, "§7Island Points: §a" . $blockPlace, 8);
			ScoreboardAPI::line($player, "              ", 9);
			ScoreboardAPI::line($player, "§aCode by Revenge8516", 10);
		}
	}

}