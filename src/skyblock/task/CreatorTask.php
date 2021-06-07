<?php


namespace skyblock\task;


use skyblock\IslandManager;

use pocketmine\Player;
use pocketmine\scheduler\Task;

class CreatorTask extends Task
{

	/** @var IslandManager */
	protected $manager;

	/** @var Player */
	protected $player;

	public function __construct(Player $player)
	{
		$this->manager = new IslandManager();
		$this->player = $player;
	}

	public function onRun(int $currentTick)
	{
		$this->manager->chestCreate($this->player);
	}

}