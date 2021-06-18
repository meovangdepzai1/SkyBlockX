<?php


namespace skyblock;


use skyblock\task\ScoreboardTask;

use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\level\Position;
use pocketmine\Player;
use pocketmine\Server;

class EventListener implements Listener
{

	/**
	 * @param PlayerJoinEvent $event
	 */
	public function onJoin(PlayerJoinEvent $event)
	{
		$player = $event->getPlayer();
		$name = $player->getName();

		/*$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$name';");
		if(empty($database->fetchArray(SQLITE3_ASSOC))) {
            if(!Server::getInstance()->isLevelLoaded($player->getName())){
                Server::getInstance()->loadLevel($player->getName());
            }
        }*/

		$database = SkyBlock::getInstance()->toplevel->query("SELECT * FROM islandLevel WHERE player = '$name';");
		if (empty($database->fetchArray(SQLITE3_ASSOC))) {
			$database = SkyBlock::getInstance()->toplevel->prepare("INSERT INTO islandLevel (player, blockPlace) VALUES (:player, :blockPlace);");
			$database->bindValue(":player", $player->getName());
			$database->bindValue(":blockPlace", "0");
			$database->execute();
		}

		SkyBlock::getInstance()->getScheduler()->scheduleRepeatingTask(new ScoreboardTask(SkyBlock::getInstance()), 20);
	}

	/**
	 * @param PlayerInteractEvent $event
	 * @return bool
	 */
	public function onInteract(PlayerInteractEvent $event)
	{
		$player = $event->getPlayer();
		$item = $event->getItem();
		if ($player instanceof Player) {
			$islandName = $player->getLevelNonNull()->getFolderName();
			$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$islandName';");
			$database = $database->fetchArray(SQLITE3_ASSOC);
			$lock = $database['lock'];
			if ($lock != "ON") {
				if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
					$name = $player->getName();
					$islandName = $player->getLevelNonNull()->getFolderName();
					$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$name' AND partnerIslandName = '$islandName';");
					if (empty($database->fetchArray(SQLITE3_ASSOC))) {
						return true;
					}
					if ($item->getId() == 8 || $item->getId() == 9 || $item->getId() == 10 || $item->getId() == 11 || $item->getId() == 51 || $item->getId() == 259 || $item->getId() == 325) {
						$event->setCancelled(true);
					}
					$event->setCancelled(true);
					$player->addTitle("", "§cIsland Owner is not your friend");
				}
			} else {
				if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
					if ($item->getId() == 8 || $item->getId() == 9 || $item->getId() == 10 || $item->getId() == 11 || $item->getId() == 51 || $item->getId() == 259 || $item->getId() == 325) {
						$event->setCancelled(true);
					}
					$event->setCancelled(true);
					$player->addTitle("", "§cIsland is lock");
				}
			}
		}
	}

	/**
	 * @param BlockBreakEvent $event
	 * @return bool
	 */
	public function onBreak(BlockBreakEvent $event)
	{
		$player = $event->getPlayer();
		$item = $event->getItem();
		if ($player instanceof Player) {
			$islandName = $player->getLevelNonNull()->getFolderName();
			$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$islandName';");
			$database = $database->fetchArray(SQLITE3_ASSOC);
			$lock = $database['lock'];
			if ($lock != "ON") {
				if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
					$name = $player->getName();
					$islandName = $player->getLevelNonNull()->getFolderName();
					$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$name' AND partnerIslandName = '$islandName';");
					if (empty($database->fetchArray(SQLITE3_ASSOC))) {
						return true;
					}
					$event->setCancelled(true);
					$player->addTitle("", "§cIsland Owner is not your friend");
				} else {
					$name = $player->getName();
					SkyBlock::getInstance()->toplevel->query("UPDATE islandLevel SET blockPlace = blockPlace - 1 WHERE player = '$name'");
				}
			} else {
				if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
					$event->setCancelled(true);
					$player->addTitle("", "§cIsland is lock");
				} else {
					$name = $player->getName();
					SkyBlock::getInstance()->toplevel->query("UPDATE islandLevel SET blockPlace = blockPlace - 1 WHERE player = '$name'");
				}
			}
		}
	}

	/**
	 * @param BlockPlaceEvent $event
	 * @return bool
	 */
	public function onPlace(BlockPlaceEvent $event)
	{
		$player = $event->getPlayer();
		$item = $event->getItem();
		if ($player instanceof Player) {
			$islandName = $player->getLevelNonNull()->getFolderName();
			$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$islandName';");
			$database = $database->fetchArray(SQLITE3_ASSOC);
			$lock = $database['lock'];
			if ($lock != "ON") {
				if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
					$name = $player->getName();
					$islandName = $player->getLevelNonNull()->getFolderName();
					$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$name' AND partnerIslandName = '$islandName';");
					if (empty($database->fetchArray(SQLITE3_ASSOC))) {
						return true;
					}
					$event->setCancelled(true);
					$player->addTitle("", "§cIsland Owner is not your friend");
				} else {
					$name = $player->getName();
					SkyBlock::getInstance()->toplevel->query("UPDATE islandLevel SET blockPlace = blockPlace + 1 WHERE player = '$name'");
				}
			} else {
				if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
					$event->setCancelled(true);
					$player->addTitle("", "§cIsland is lock");
				} else {
					$name = $player->getName();
					SkyBlock::getInstance()->toplevel->query("UPDATE islandLevel SET blockPlace = blockPlace + 1 WHERE player = '$name'");
				}
			}
		}
	}

	/**
	 * @param EntityDamageEvent $event
	 */
	public function onEntityDamage(EntityDamageEvent $event)
	{
		if ($event instanceof EntityDamageByEntityEvent) {
			if ($event->getEntity() instanceof Player && $event->getDamager() instanceof Player) {
				$player = $event->getEntity();
				$island = $player->getLevel()->getName();
				$dir = Server::getInstance()->getDataPath() . "worlds/" . $player->getName();
				if (file_exists($dir)) {
					$event->setCancelled(true);
				}
			}
		}
		$voidPlayer = $event->getEntity();
		if ($voidPlayer instanceof Player) {
			if ($event->getCause() === EntityDamageEvent::CAUSE_VOID) {
				$event->setCancelled();
				$level = Server::getInstance()->getLevelByName($voidPlayer->getName());
				$voidPlayer->teleport(new Position(4, 4, 5, $level));
			}
		}
	}
}