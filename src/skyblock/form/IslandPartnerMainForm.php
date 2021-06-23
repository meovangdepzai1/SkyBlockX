<?php


namespace skyblock\form;


use pocketmine\form\MenuForm;
use pocketmine\form\MenuOption;
use pocketmine\Player;

class IslandPartnerMainForm extends MenuForm
{

    /**
     * IslandPartnerMainForm constructor.
     */
    public function __construct()
	{
		parent::__construct(
			"Island Partner",
			"",
			[
				new MenuOption("§l§a•§eThêm§a•"),
				new MenuOption("§l§a•§eXóa§a•"),
				new MenuOption("§l§a•§ePartner Teleport§a•")
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
