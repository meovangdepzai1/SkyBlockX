<?php


namespace skyblock;


use skyblock\command\Island;
use skyblock\command\TopLeaderboard;
use skyblock\entity\FloatingTextEntity;
use skyblock\generator\BasicIslandGenerator;

use pocketmine\entity\Entity;
use pocketmine\utils\Config;
use pocketmine\level\generator\GeneratorManager;
use pocketmine\plugin\PluginBase;

class SkyBlock extends PluginBase
{

	/** @var SkyBlock */
	static public $instance;

	/** @var \SQLite3 */
	public $sqlite;

	/** @var \SQLite3 */
	public $toplevel;

	/** @var Config */
	public $config;

	/** @var string */
	public const PREFIX = "§aSKYBLOCK §8> ";

	/** @var string */
	public const SCOREBOARD = "§l§6SKYBLOCK";

	public static function getInstance(): SkyBlock
	{
		return self::$instance;
	}

	public function onEnable(): void
	{
		self::$instance = $this;

		self::$instance->getLogger()->info("SkyBlock enabled! by 'Revenge.#0001");

		self::$instance->getServer()->getCommandMap()->register("island", new Island());
		self::$instance->getServer()->getCommandMap()->register("topleaderboard", new TopLeaderboard());

		GeneratorManager::addGenerator(BasicIslandGenerator::class, "basic", true);

		Entity::registerEntity(FloatingTextEntity::class, true);

		self::$instance->getServer()->getPluginManager()->registerEvents(new EventListener(), self::$instance);

		$this->config = new Config(self::$instance->getDataFolder() . "config.yml", Config::YAML, [
		    "leaderboardworld" => "world"
        ]);

		$this->sqlite = new \SQLite3(self::$instance->getDataFolder() . "skyblock.db");
		$this->sqlite->exec("CREATE TABLE IF NOT EXISTS skyblock(player TEXT PRIMARY KEY, islandTeleport TEXT, lock TEXT, visit TEXT, islandName TEXT);");
		$this->sqlite->exec("CREATE TABLE IF NOT EXISTS partner(player TEXT, partnerIslandName TEXT);");

		$this->toplevel = new \SQLite3(self::$instance->getDataFolder() . "topisland.db");
		$this->toplevel->exec("CREATE TABLE IF NOT EXISTS islandLevel(player TEXT PRIMARY KEY, blockPlace INT);");
	}

}