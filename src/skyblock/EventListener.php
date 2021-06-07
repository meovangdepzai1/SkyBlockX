<?php


namespace skyblock;


use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\Player;

class EventListener implements Listener
{

	/**
	 * @param PlayerInteractEvent $event
	 */
	public function onInteract(PlayerInteractEvent $event)
	{
		$player = $event->getPlayer();
		$item = $event->getItem();
		$islandName = $player->getLevelNonNull()->getFolderName();
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$islandName';");
		$database = $database->fetchArray(SQLITE3_ASSOC);
		$lock = $database['lock'];
		if ($lock != "ON") {
			if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
				$name = $player->getName();
				$islandName = $player->getLevelNonNull()->getFolderName();
				$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$name' and partnerIslandName = '$islandName';");
				if (!empty($database->fetchArray(SQLITE3_ASSOC))) {
					return true;
				}
				if ($item->getId() == 8 || $item->getId() == 9 || $item->getId() == 10 || $item->getId() == 11 || $item->getId() == 51 || $item->getId() == 259 || $item->getId() == 325) {
					$event->setCancelled(true);
				}
				$event->setCancelled(true);
				$player->addTitle("", "§cIsland Owner is not your friend", 20, 20, 20);
			}
		} else {
			if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
				if ($item->getId() == 8 || $item->getId() == 9 || $item->getId() == 10 || $item->getId() == 11 || $item->getId() == 51 || $item->getId() == 259 || $item->getId() == 325) {
					$event->setCancelled(true);
				}
				$event->setCancelled(true);
				$player->addTitle("", "§cIsland is lock", 20, 20, 20);
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
		$islandName = $player->getLevelNonNull()->getFolderName();
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$islandName';");
		$database = $database->fetchArray(SQLITE3_ASSOC);
		$lock = $database['lock'];
		if ($lock != "ON") {
			if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
				$name = $player->getName();
				$islandName = $player->getLevelNonNull()->getFolderName();
				$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$name' and partnerIslandName = '$islandName';");
				if (!empty($database->fetchArray(SQLITE3_ASSOC))) {
					return true;
				}
				$event->setCancelled(true);
				$player->addTitle("", "§cIsland Owner is not your friend", 20, 20, 20);
			}
		} else {
			$event->setCancelled(true);
			$player->addTitle("", "§cIsland is lock", 20, 20, 20);
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
		$islandName = $player->getLevelNonNull()->getFolderName();
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$islandName';");
		$database = $database->fetchArray(SQLITE3_ASSOC);
		$lock = $database['lock'];
		if ($lock != "ON") {
			if ($player->getName() != $player->getLevelNonNull()->getFolderName()) {
				$name = $player->getName();
				$islandName = $player->getLevelNonNull()->getFolderName();
				$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM partner WHERE player = '$name' and partnerIslandName = '$islandName';");
				if (!empty($database->fetchArray(SQLITE3_ASSOC))) {
					return true;
				}
				$event->setCancelled(true);
				$player->addTitle("", "§cIsland Owner is not your friend", 20, 20, 20);
			}
		} else {
			$event->setCancelled(true);
			$player->addTitle("", "§cIsland is lock", 20, 20, 20);
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
	}

}