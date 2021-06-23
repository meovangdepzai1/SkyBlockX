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
			"§4§l∆cXoá Đảo§4∆",
			"§9§l Này,§e{$player->getName()}, Bạn Có muốn xoá ngôi đảo này??",
			function (Player $player, bool $choice): void {
				if ($choice == true) {
					IslandManager::islandDelete($player);
				}
			}
		);
	}

}
