<?php


namespace skyblock\generator;


use pocketmine\block\Block;
use pocketmine\level\ChunkManager;
use pocketmine\level\generator\Generator;
use pocketmine\math\Vector3;
use pocketmine\utils\Random;

class BasicIslandGenerator extends Generator
{

	/** @var array */
	private $settings;

	/** @var Island Type Name */
	private $name;

	/** @var Level */
	protected $level;

	/** @var Random */
	protected $random;

	public function __construct(array $settings = [])
	{
		$this->settings = $settings;
	}

	public function init(ChunkManager $level, Random $random): void
	{
		$this->level = $level;
		$this->random = $random;
		$this->name = "basic";
		$this->islandName = "Basic Island";
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function getSettings(): array
	{
		return $this->settings;
	}

	public function generateChunk(int $chunkX, int $chunkZ): void
	{
		$chunk = $this->level->getChunk($chunkX, $chunkZ);
		$chunk->setGenerated();
		if ($chunkX == 0 and $chunkZ == 0) {
			$chunk->setBlock(4, 2, 7, Block::DIRT);
			$chunk->setBlock(3, 2, 6, Block::DIRT);
			$chunk->setBlock(4, 2, 6, Block::DIRT);
			$chunk->setBlock(5, 2, 6, Block::DIRT);
			$chunk->setBlock(6, 2, 5, Block::DIRT);
			$chunk->setBlock(5, 2, 5, Block::DIRT);
			$chunk->setBlock(3, 2, 5, Block::DIRT);
			$chunk->setBlock(2, 2, 5, Block::DIRT);
			$chunk->setBlock(1, 2, 4, Block::DIRT);
			$chunk->setBlock(2, 2, 4, Block::DIRT);
			$chunk->setBlock(3, 2, 4, Block::DIRT);
			$chunk->setBlock(4, 2, 4, Block::DIRT);
			$chunk->setBlock(5, 2, 4, Block::DIRT);
			$chunk->setBlock(6, 2, 4, Block::DIRT);
			$chunk->setBlock(7, 2, 4, Block::DIRT);
			$chunk->setBlock(3, 2, 2, Block::DIRT);
			$chunk->setBlock(3, 2, 3, Block::DIRT);
			$chunk->setBlock(3, 2, 4, Block::DIRT);
			$chunk->setBlock(3, 2, 5, Block::DIRT);
			$chunk->setBlock(3, 2, 6, Block::DIRT);
			$chunk->setBlock(2, 2, 3, Block::DIRT);
			$chunk->setBlock(2, 2, 4, Block::DIRT);
			$chunk->setBlock(2, 2, 5, Block::DIRT);
			$chunk->setBlock(1, 2, 4, Block::DIRT);
			$chunk->setBlock(4, 1, 3, Block::DIRT);
			$chunk->setBlock(5, 1, 4, Block::DIRT);
			$chunk->setBlock(4, 1, 4, Block::DIRT);
			$chunk->setBlock(3, 1, 4, Block::DIRT);
			$chunk->setBlock(4, 2, 3, Block::DIRT);
			$chunk->setBlock(5, 2, 3, Block::DIRT);
			$chunk->setBlock(6, 2, 3, Block::DIRT);
			$chunk->setBlock(5, 2, 2, Block::DIRT);
			$chunk->setBlock(4, 2, 1, Block::DIRT);
			$chunk->setBlock(4, 2, 2, Block::DIRT);
			$chunk->setBlock(4, 2, 5, Block::DIRT);
			$chunk->setBlock(4, 1, 5, Block::DIRT);
			$chunk->setBlock(3, 1, 3, Block::DIRT);
			$chunk->setBlock(2, 1, 4, Block::DIRT);
			$chunk->setBlock(3, 1, 5, Block::DIRT);
			$chunk->setBlock(4, 1, 6, Block::DIRT);
			$chunk->setBlock(5, 1, 5, Block::DIRT);
			$chunk->setBlock(6, 1, 4, Block::DIRT);
			$chunk->setBlock(5, 1, 3, Block::DIRT);
			$chunk->setBlock(4, 1, 2, Block::DIRT);
			$chunk->setBlock(4, 0, 4, Block::DIRT);
			$chunk->setBlock(1, 3, 7, Block::AIR);
			$chunk->setBlock(1, 3, 1, Block::AIR);
			$chunk->setBlock(7, 3, 1, Block::AIR);
			$chunk->setBlock(7, 3, 7, Block::AIR);
			$chunk->setBlock(6, 3, 7, Block::GRASS);
			$chunk->setBlock(5, 3, 7, Block::GRASS);
			$chunk->setBlock(4, 3, 7, Block::GRASS);
			$chunk->setBlock(3, 3, 7, Block::GRASS);
			$chunk->setBlock(2, 3, 7, Block::GRASS);
			$chunk->setBlock(7, 3, 6, Block::GRASS);
			$chunk->setBlock(6, 3, 6, Block::GRASS);
			$chunk->setBlock(5, 3, 6, Block::GRASS);
			$chunk->setBlock(4, 3, 6, Block::GRASS);
			$chunk->setBlock(3, 3, 6, Block::GRASS);
			$chunk->setBlock(2, 3, 6, Block::GRASS);
			$chunk->setBlock(1, 3, 6, Block::GRASS);
			$chunk->setBlock(7, 3, 5, Block::GRASS);
			$chunk->setBlock(6, 3, 5, Block::GRASS);
			$chunk->setBlock(5, 3, 5, Block::GRASS);
			$chunk->setBlock(4, 3, 5, Block::GRASS);
			$chunk->setBlock(3, 3, 5, Block::GRASS);
			$chunk->setBlock(2, 3, 5, Block::GRASS);
			$chunk->setBlock(1, 3, 5, Block::GRASS);
			$chunk->setBlock(7, 3, 4, Block::GRASS);
			$chunk->setBlock(6, 3, 4, Block::GRASS);
			$chunk->setBlock(5, 3, 4, Block::GRASS);
			$chunk->setBlock(4, 3, 4, Block::GRASS);
			$chunk->setBlock(3, 3, 4, Block::GRASS);
			$chunk->setBlock(2, 3, 4, Block::GRASS);
			$chunk->setBlock(1, 3, 4, Block::GRASS);
			$chunk->setBlock(7, 3, 3, Block::GRASS);
			$chunk->setBlock(6, 3, 3, Block::GRASS);
			$chunk->setBlock(5, 3, 3, Block::GRASS);
			$chunk->setBlock(4, 3, 3, Block::GRASS);
			$chunk->setBlock(3, 3, 3, Block::GRASS);
			$chunk->setBlock(2, 3, 3, Block::GRASS);
			$chunk->setBlock(1, 3, 3, Block::GRASS);
			$chunk->setBlock(7, 3, 2, Block::GRASS);
			$chunk->setBlock(6, 3, 2, Block::GRASS);
			$chunk->setBlock(5, 3, 2, Block::GRASS);
			$chunk->setBlock(4, 3, 2, Block::GRASS);
			$chunk->setBlock(3, 3, 2, Block::GRASS);
			$chunk->setBlock(2, 3, 2, Block::GRASS);
			$chunk->setBlock(1, 3, 2, Block::GRASS);
			$chunk->setBlock(6, 3, 1, Block::GRASS);
			$chunk->setBlock(5, 3, 1, Block::GRASS);
			$chunk->setBlock(4, 3, 1, Block::GRASS);
			$chunk->setBlock(3, 3, 1, Block::GRASS);
			$chunk->setBlock(2, 3, 1, Block::GRASS);
			$chunk->setBlock(4, 4, 4, Block::WOOD);
			$chunk->setBlock(4, 5, 4, Block::WOOD);
			$chunk->setBlock(4, 6, 4, Block::WOOD);
			$chunk->setBlock(4, 7, 4, Block::WOOD);
			$chunk->setBlock(4, 8, 4, Block::WOOD);
			$chunk->setBlock(7, 8, 4, Block::LEAVES);
			$chunk->setBlock(6, 8, 3, Block::LEAVES);
			$chunk->setBlock(6, 8, 4, Block::LEAVES);
			$chunk->setBlock(6, 8, 5, Block::LEAVES);
			$chunk->setBlock(5, 8, 2, Block::LEAVES);
			$chunk->setBlock(5, 8, 3, Block::LEAVES);
			$chunk->setBlock(5, 8, 4, Block::LEAVES);
			$chunk->setBlock(5, 8, 5, Block::LEAVES);
			$chunk->setBlock(5, 8, 6, Block::LEAVES);
			$chunk->setBlock(4, 8, 1, Block::LEAVES);
			$chunk->setBlock(4, 8, 2, Block::LEAVES);
			$chunk->setBlock(4, 8, 3, Block::LEAVES);
			$chunk->setBlock(4, 8, 5, Block::LEAVES);
			$chunk->setBlock(4, 8, 6, Block::LEAVES);
			$chunk->setBlock(4, 8, 7, Block::LEAVES);
			$chunk->setBlock(3, 8, 6, Block::LEAVES);
			$chunk->setBlock(3, 8, 5, Block::LEAVES);
			$chunk->setBlock(3, 8, 4, Block::LEAVES);
			$chunk->setBlock(3, 8, 3, Block::LEAVES);
			$chunk->setBlock(3, 8, 2, Block::LEAVES);
			$chunk->setBlock(2, 8, 5, Block::LEAVES);
			$chunk->setBlock(2, 8, 4, Block::LEAVES);
			$chunk->setBlock(2, 8, 3, Block::LEAVES);
			$chunk->setBlock(1, 8, 4, Block::LEAVES);
			$chunk->setBlock(6, 9, 4, Block::LEAVES);
			$chunk->setBlock(5, 9, 3, Block::LEAVES);
			$chunk->setBlock(5, 9, 4, Block::LEAVES);
			$chunk->setBlock(5, 9, 3, Block::LEAVES);
			$chunk->setBlock(4, 9, 2, Block::LEAVES);
			$chunk->setBlock(4, 9, 3, Block::LEAVES);
			$chunk->setBlock(4, 9, 4, Block::LEAVES);
			$chunk->setBlock(4, 9, 5, Block::LEAVES);
			$chunk->setBlock(4, 9, 6, Block::LEAVES);
			$chunk->setBlock(3, 9, 3, Block::LEAVES);
			$chunk->setBlock(3, 9, 4, Block::LEAVES);
			$chunk->setBlock(3, 9, 5, Block::LEAVES);
			$chunk->setBlock(2, 9, 4, Block::LEAVES);
			$chunk->setBlock(5, 10, 4, Block::LEAVES);
			$chunk->setBlock(4, 10, 5, Block::LEAVES);
			$chunk->setBlock(4, 10, 4, Block::LEAVES);
			$chunk->setBlock(4, 10, 3, Block::LEAVES);
			$chunk->setBlock(3, 10, 4, Block::LEAVES);
			$chunk->setBlock(4, 11, 4, Block::LEAVES);
			$chunk->setX($chunkX);
			$chunk->setZ($chunkZ);
			$this->level->setChunk($chunkX, $chunkZ, $chunk);
		}
	}

	public function populateChunk(int $chunkX, int $chunkZ): void
	{
	}

	public function getSpawn(): Vector3
	{
		return new Vector3(4, 4, 5);
	}
}