<?php

/*
 *
 *  ____            _        _   __  __ _                  __  __ ____
 * |  _ \ ___   ___| | _____| |_|  \/  (_)_ __   ___      |  \/  |  _ \
 * | |_) / _ \ / __| |/ / _ \ __| |\/| | | '_ \ / _ \_____| |\/| | |_) |
 * |  __/ (_) | (__|   <  __/ |_| |  | | | | | |  __/_____| |  | |  __/
 * |_|   \___/ \___|_|\_\___|\__|_|  |_|_|_| |_|\___|     |_|  |_|_|
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

namespace pocketmine\block;

use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\Player;

class DoublePlant extends Flowable{

	protected $id = self::DOUBLE_PLANT;

	public function __construct($meta = 0){
		$this->meta = $meta;
	}

	public function canBeReplaced(){
		return true;
	}

	public function getName(){
		static $names = [
			0 => "Sunflower",
			1 => "Lilac",
			2 => "Double Tallgrass",
			3 => "Large Fern",
			4 => "Rose Bush",
			5 => "Peony"
		];
		return $names[$this->meta & 0x07];
	}

	public function onBreak(Item $item){
		$down = $this->getSide(0);
		if($down->getId() == Block::DOUBLE_PLANT){
			$this->getLevel()->setBlock($this, new Air(), true, true);
			$this->getLevel()->setBlock($this->add(0, -1, 0), new Air(), true, true);
		}else{
			$this->getLevel()->setBlock($this, new Air(), true, true);
			$this->getLevel()->setBlock($this->add(0, 1, 0), new Air(), true, true);
		}
		return true;
	}

	public function onUpdate($type){
		if($type === Level::BLOCK_UPDATE_NORMAL){
			if($this->meta & 0x8 == 0 && $this->getSide(0)->isTransparent() === true){ //Replace with common break method
				$this->getLevel()->setBlock($this, new Air(), false, false, true);

				return Level::BLOCK_UPDATE_NORMAL;
			}
		}

		return false;
	}
	public function place(Item $item, Block $block, Block $target, $face, $fx, $fy, $fz, Player $player = null){
		$down = $this->getSide(0);
		if($down->getId() == 2 or $down->getId() == 3){ //TODO destroy the block above(tested only in creative)
			$this->getLevel()->setBlock($block, $this, true, false, true);
			$this->getLevel()->setBlock($block->add(0, 1, 0), new DoublePlant($this->meta ^ 0x8), true, false, true);
			return true;
		}
		return false;
	}

	public function getDrops(Item $item){
		//TODO

		return [];
	}

}
