<?php


namespace skyblock\command;


use skyblock\SkyBlock;
use skyblock\form\IslandCreateForm;
use skyblock\form\IslandMainForm;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Island extends Command
{

	public function __construct()
	{
		parent::__construct("island", "Island Menu Open");
	}

    /**
     * @param CommandSender $player
     * @param string $commandLabel
     * @param array $args
     * @return mixed|void
     */
    public function execute(CommandSender $player, string $commandLabel, array $args)
	{
		$playerName = $player->getName();
		$database = SkyBlock::getInstance()->sqlite->query("SELECT * FROM skyblock WHERE player = '$playerName'");
		if (empty($database->fetchArray(SQLITE3_ASSOC))) {
			$player->sendForm(new IslandCreateForm($player));
		} else {
			$player->sendForm(new IslandMainForm($player));
		}
	}

}