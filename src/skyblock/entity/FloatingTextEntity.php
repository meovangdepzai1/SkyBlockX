<?php

namespace skyblock\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\EntityIds;
use pocketmine\entity\Monster;
use skyblock\SkyBlock;

class FloatingTextEntity extends Monster
{

    /** @var int */
    const NETWORK_ID = EntityIds::CHICKEN;

    /** @var float */
    public $height = 0.7;

    /** @var float */
    public $width = 0.4;

    /** @var int */
    public $gravity = 0;

    /**
     * @return string
     */
    public function getName(): string
    {
        return "FloatingTextEntity";
    }

    /**
     * @mixed void
     */
    public function initEntity(): void
    {
        parent::initEntity(); //TODO: Change
        $this->setImmobile(true);
        $this->setHealth($this->getHealth());
        $this->setNameTagAlwaysVisible(true);
        $this->setScale(0.001);
    }

    /**
     * @param int $currentTick
     * @return bool
     */
    public function onUpdate(int $currentTick): bool
    {
        $database = SkyBlock::getInstance()->toplevel->query("SELECT * FROM islandLevel ORDER BY blockPlace DESC LIMIT 10;");
        $top = 1;
        $array = $database->fetchArray(SQLITE3_ASSOC);
        $nametag = "§aSKYBLOCK TOP ISLAND POINTS\n\n";
        while ($array) {
            $dbPlayer = $array['player'];
            $dbPoints = $array['blockPlace'];
            if ($top > 5) break;
            $nametag .= "§7[$top] > §a" . $dbPlayer . " §7| §e" . $dbPoints . "\n";
            $top++;
        }
        $this->setNameTag($nametag);
        return parent::onUpdate($currentTick);
    }

}