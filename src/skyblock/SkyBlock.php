<?php


namespace skyblock;


use skyblock\command\Island;
use skyblock\generator\BasicIslandGenerator;

use pocketmine\level\generator\GeneratorManager;
use pocketmine\plugin\PluginBase;

class SkyBlock extends PluginBase
{

	/** @var SkyBlock */
	static public $instance;

	/** @var \SQLite3 */
	public $sqlite;

	/** @var string */
	public const PREFIX = "§aSKYBLOCK §8> ";

	public static function getInstance(): SkyBlock
	{
		return self::$instance;
	}

	public function onEnable(): void
	{
		self::$instance = $this;

		self::$instance->getLogger()->info("SkyBlock enabled! by 'Revenge.#1006");

		self::$instance->getServer()->getCommandMap()->register("island", new Island());

		GeneratorManager::addGenerator(BasicIslandGenerator::class, "basic", true);

		self::$instance->getServer()->getPluginManager()->registerEvents(new EventListener(), self::$instance);

		$this->sqlite = new \SQLite3($this->getDataFolder() . "skyblock.db");
		$this->sqlite->exec("CREATE TABLE IF NOT EXISTS skyblock(player TEXT PRIMARY KEY, islandTeleport TEXT, lock TEXT, visit TEXT, islandName TEXT);");
		$this->sqlite->exec("CREATE TABLE IF NOT EXISTS partner(player TEXT, partnerIslandName TEXT);");
	}

}