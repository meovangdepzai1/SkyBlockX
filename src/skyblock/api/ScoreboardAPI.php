<?php


namespace skyblock\api;


use pocketmine\Player;
use pocketmine\network\mcpe\protocol\types\ScorePacketEntry;
use pocketmine\network\mcpe\protocol\SetScorePacket;
use pocketmine\network\mcpe\protocol\SetDisplayObjectivePacket;
use skyblock\SkyBlock;

class ScoreboardAPI
{

	/**
	 * @param Player $player
	 */
	public static function title(Player $player)
	{
		$score = 10;
		$packet = new SetDisplayObjectivePacket();
		$packet->displaySlot = "sidebar";
		$packet->objectiveName = "scoreboard";
		$packet->displayName = SkyBlock::SCOREBOARD;
		$packet->criteriaName = "dummy";
		$packet->sortOrder = 0;
		$player->sendDataPacket($packet);
	}

	/**
	 * @param Player $player
	 * @param string $text
	 * @param int $id
	 */
	public static function line(Player $player, string $text, int $id)
	{
		$entrie = new ScorePacketEntry();
		$entrie->objectiveName = "scoreboard";
		$entrie->type = ScorePacketEntry::TYPE_FAKE_PLAYER;
		$entrie->customName = $text;
		$entrie->score = $id;
		$entrie->scoreboardId = $id;
		$packet = new SetScorePacket();
		$packet->type = 0;
		$packet->entries[] = $entrie;
		$player->sendDataPacket($packet);
	}
}