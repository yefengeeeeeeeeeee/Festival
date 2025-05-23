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

namespace pocketmine\network\protocol;

use pocketmine\utils\Binary;
use function chr;
use function ord;

class PlayerArmorEquipmentPacket extends DataPacket{
	const NETWORK_ID = Info::PLAYER_ARMOR_EQUIPMENT_PACKET;

	public $eid;
	public $slots = [];

	public function decode(){
		$this->eid = Binary::readLong($this->get(8));
		$this->slots[0] = ord($this->get(1));
		$this->slots[1] = ord($this->get(1));
		$this->slots[2] = ord($this->get(1));
		$this->slots[3] = ord($this->get(1));
	}

	public function encode(){
		$this->buffer = chr(self::NETWORK_ID); $this->offset = 0;;
		$this->buffer .= Binary::writeLong($this->eid);
		$this->buffer .= chr($this->slots[0]);
		$this->buffer .= chr($this->slots[1]);
		$this->buffer .= chr($this->slots[2]);
		$this->buffer .= chr($this->slots[3]);
	}

}
