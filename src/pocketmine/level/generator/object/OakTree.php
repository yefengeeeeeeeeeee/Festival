<?php

/*
 *
 * ____ _ _ __ __ _ __ __ ____
 * | _ \ ___ ___| | _____| |_| \/ (_)_ __ ___ | \/ | _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * | __/ (_) | (__| < __/ |_| | | | | | | | __/_____| | | | __/
 * |_| \___/ \___|_|\_\___|\__|_| |_|_|_| |_|\___| |_| |_|_|
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author PocketMine Team
 * @link http://www.pocketmine.net/
 *
 *
 */
namespace pocketmine\level\generator\object;

use pocketmine\block\Block;
use pocketmine\block\Wood;
use pocketmine\level\ChunkManager;
use pocketmine\utils\Random;

class OakTree extends Tree
{

	public function __construct()
	{
		$this->trunkBlock = Block::LOG;
		$this->leafBlock = Block::LEAVES;
		$this->type = Wood::OAK;
	}

	public function placeObject(ChunkManager $level, $x, $y, $z, Random $random)
	{
		$this->treeHeight = $random->nextBoundedInt(3) + 4;
		parent::placeObject($level, $x, $y, $z, $random);
	}
}