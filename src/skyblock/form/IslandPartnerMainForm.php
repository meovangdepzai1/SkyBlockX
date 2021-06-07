<?php


namespace skyblock\form;


use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;

class IslandPartnerMainForm extends MenuForm
{

	public function __construct()
	{
		parent::__construct(
			"Island Partner",
			"",
			[
				new MenuOption("Add"),
				new MenuOption("Remove"),
				new MenuOption("Partner Island Teleport")
			],
			function (Player $player, int $dataOption): void {
				if ($dataOption === 0) {
					$player->sendForm(new IslandPartnerAddForm($player));
				}
				if ($dataOption === 1) {
					$player->sendForm(new IslandPartnerRemoveForm($player));
				}
				if ($dataOption === 2) {
					$player->sendForm(new IslandPartnerTeleportForm($player));
				}
			}
		);
	}

}