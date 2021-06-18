<?php


namespace skyblock\form;


use skyblock\IslandManager;

use pocketmine\form\ModalForm;
use pocketmine\Player;

class IslandDeleteRequireForm extends ModalForm
{

    /**
     * IslandDeleteRequireForm constructor.
     * @param Player $player
     */
    public function __construct(Player $player)
	{
		parent::__construct(
			"Island Delete",
			"{$player->getName()} Do you want your island?",
			function (Player $player, bool $choice): void {
				if ($choice == true) {
					IslandManager::islandDelete($player);
				}
			}
		);
	}

}