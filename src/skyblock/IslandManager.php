<?php


namespace skyblock;


use skyblock\task\CreatorTask;
use skyblock\generator\BasicIslandGenerator;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\level\Position;
use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\IntTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\tile\Tile;
use pocketmine\Player;
use pocketmine\Server;

class IslandManager
{

	public static function islandCreate(Player $player)
	{
		$database = SkyBlock::getInstance()->sqlite->prepare("INSERT INTO skyblock (player, islandName, lock, visit) VALUES (:player, :islandName, :lock, :visit);");
		$database->bindValue(":player", $player->getName());
		$database->bindValue(":islandName", $player->getName());
		$database->bindValue(":lock", "OFF");
		$database->bindValue(":visit", "OFF");
		$database->execute();
		Server::getInstance()->generateLevel($player->getName(), null, BasicIslandGenerator::class);
		$player->sendMessage(SkyBlock::PREFIX . "§aYour island has been successfully created");

	}

	public static function islandTeleport(Player $player)
	{
		if (!Server::getInstance()->isLevelLoaded($player->getName())) Server::getInstance()->loadLevel($player->getName());
		$level = Server::getInstance()->getLevelByName($player->getName());
		$player->teleport(new Position(4, 4, 5, $level));
		$name = $player->getName();
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE islandTeleport = '$name'");
		if (empty($database->fetchArray(SQLITE3_ASSOC))) {
			$database = SkyBlock::getInstance()->sqlite->prepare("INSERT INTO skyblock (islandTeleport) VALUES (:islandTeleport);");
			$database->bindValue(":islandTeleport", $player->getName());
			$database->execute();
		}
		SkyBlock::getInstance()->getScheduler()->scheduleDelayedTask(new CreatorTask($player), 60);
		$player->sendMessage(SkyBlock::PREFIX . "§c§l•>§eĐã dịch chuyển đến đảo của bạn");
	}

	public static function islandVisit(Player $player, string $selectedPlayer)
	{
		$selectedPlayer = Server::getInstance()->getPlayerExact($selectedPlayer);
		if($selectedPlayer instanceof Player) {
			$player->sendMessage(SkyBlock::PREFIX . "§c§l•>§eBạn Không ở đảo của mình");
			return true;
		}
		if(Server::getInstance()->isLevelLoaded($selectedPlayer->getName())) {
			$level = Server::getInstance()->getLevelByName($player->getName());
			$player->teleport(new Position(3, 4, 5, $level));
			$player->sendMessage(SkyBlock::PREFIX . "§e" . $selectedPlayer->getName() . " §c§l•>§eDịch chuyển đến đảo người khác thành công");
			$selectedPlayer->sendMessage(SkyBlock::PREFIX . "§e" . $player->getName() . " §c§l•>§eNgười Chơi dịch chuyển đến đảo");
		}
	}

	public function chestCreate(Player $player)
	{
		$level = Server::getInstance()->getLevelByName($player->getName());
		$level->loadChunk(5, 4, true);
		$level->setBlock(new Vector3(5, 4, 4), new Block(54, 0));
		$nbt = new CompoundTag(" ", [
			new StringTag("id", Tile::CHEST),
			new IntTag("x", 8),
			new IntTag("y", 35),
			new IntTag("z", 6)
		]);
		$chest = Tile::createTile("Chest", $level, $nbt);
		$level->addTile($chest);
		$inventory = $chest->getInventory();
		$inventory->addItem(Item::get(Item::WATER, 0, 2));
		$inventory->addItem(Item::get(Item::LAVA, 0, 2));
		$inventory->addItem(Item::get(Item::WHEAT_SEEDS, 0, 2));
		$inventory->addItem(Item::get(Item::PUMPKIN_SEEDS, 0, 2));
		$inventory->addItem(Item::get(Item::SUGARCANE, 0, 2));
		$inventory->addItem(Item::get(Item::BREAD, 0, 2));
                $inventory->addItem(Item::get(Item::DIAMOND_PICKAXE, 1, 1));
	}

	public static function changeIslandLock(Player $player)
	{
		$name = $player->getName();
		$playerLock = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$name';");
		$playerLock = $playerLock->fetchArray(SQLITE3_ASSOC);
		$lock = $playerLock['lock'];
		if ($lock == "OFF") {
			$database = SkyBlock::getInstance()->sqlite->prepare("INSERT OR REPLACE INTO skyblock (player, lock) VALUES (:player, :lock)");
			$database->bindValue(":player", $player->getName());
			$database->bindValue(":lock", "ON");
			$database->execute();
			$player->sendMessage(SkyBlock::PREFIX . "§c§l->§eBạn đã khoá đảo ");
		} else {
			$database = SkyBlock::getInstance()->sqlite->prepare("INSERT OR REPLACE INTO skyblock (player, lock) VALUES (:player, :lock)");
			$database->bindValue(":player", $player->getName());
			$database->bindValue(":lock", "OFF");
			$database->execute();
			$player->sendMessage(SkyBlock::PREFIX . "§aYour Island Lock has been switch OFF");
		}
	}

	public static function changeIslandVisit(Player $player)
	{
		$name = $player->getName();
		$playerVisit = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$name';");
		$playerVisit = $playerVisit->fetchArray(SQLITE3_ASSOC);
		$visit = $playerVisit['visit'];
		if ($visit == "OFF") {
			$database = SkyBlock::getInstance()->sqlite->prepare("INSERT OR REPLACE INTO skyblock (player, visit) VALUES (:player, :visit)");
			$database->bindValue(":player", $player->getName());
			$database->bindValue(":visit", "ON");
			$database->execute();
			$player->sendMessage(SkyBlock::PREFIX . "§c§l->§eBạn đã khoá đảo");
		} else {
			$database = SkyBlock::getInstance()->sqlite->prepare("INSERT OR REPLACE INTO skyblock (player, visit) VALUES (:player, :visit)");
			$database->bindValue(":player", $player->getName());
			$database->bindValue(":visit", "OFF");
			$database->execute();
			$player->sendMessage(SkyBlock::PREFIX . "§c§l->§eBạn đã mở đảo");
		}
	}

	public static function islandDelete(Player $player)
	{
		$player->teleport(Server::getInstance()->getDefaultLevel()->getSafeSpawn());
		$name = $player->getName();
		#SQLITE Delete
		SkyBlock::getInstance()->sqlite->query("DELETE FROM skyblock WHERE player = '$name'");
		SkyBlock::getInstance()->sqlite->query("DELETE FROM partner WHERE partnerIslandName = '$name'");
		SkyBlock::getInstance()->toplevel->query("DELETE FROM islandLevel WHERE player = '$name'");
		#DELETE ISLAND WORLD
		$dir = Server::getInstance()->getDataPath() . "worlds/" . $player->getName() . "/region";
		$dir = rtrim($dir, "/\\") . "/";
		foreach (scandir($dir) as $file) {
			if ($file === "." or $file === "..") {
				continue;
			}
			$path = $dir . $file;
			if (is_dir($path)) {
			} else {
				unlink($path);
			}
		}
		rmdir($dir);
		$dir = Server::getInstance()->getDataPath() . "worlds/" . $player->getName();
		$dir = rtrim($dir, "/\\") . "/";
		foreach (scandir($dir) as $file) {
			if ($file === "." or $file === "..") {
				continue;
			}
			$path = $dir . $file;
			if (is_dir($path)) {
			} else {
				unlink($path);
			}
		}
		rmdir($dir);
		$player->sendMessage(SkyBlock::PREFIX . "§c§l->§eXoá Đảo thành công");
	}

}
