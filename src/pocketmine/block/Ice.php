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

class Ice extends Transparent{

	protected $id = self::ICE;
	public $slipperiness = 0.98;
	public function __construct(){

	}

	public function getName(){
		return "Ice";
	}

	public function getHardness(){
		return 2.5;
	}

	public function onBreak(Item $item){
		$this->getLevel()->setBlock($this, new Water(), true);

		return true;
	}

	public function getBreakTime(Item $item){
		switch($item->isPickaxe()){
			case 5:
				return 0.1;
			case 4:
				return 0.15;
			case 3:
				return 0.2;
			case 2:
				return 0.1;
			case 1:
				return 0.4;
			default:
				return 0.75;
		}
	}

	public function getDrops(Item $item){
		return [];
	}
}