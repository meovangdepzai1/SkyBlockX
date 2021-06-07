<?php


namespace skyblock\form;


use skyblock\IslandManager;

use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;

class IslandCreateForm extends MenuForm
{

	public function __construct(Player $player)
	{
		parent::__construct(
			"Island Create",
			"",
			[
				new MenuOption("Basic Island")
			],
			function (Player $player, int $dataOption): void {
				if ($dataOption === 0) IslandManager::islandCreate($player);
			}
		);
	}

}