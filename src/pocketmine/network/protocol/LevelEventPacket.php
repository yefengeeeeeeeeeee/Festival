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

use function chr;
use function pack;
use function strrev;

class LevelEventPacket extends DataPacket{
	const NETWORK_ID = Info::LEVEL_EVENT_PACKET;

	public $evid;
	public $x;
	public $y;
	public $z;
	public $data;

	public function decode(){

	}

	public function encode(){
		$this->buffer = chr(self::NETWORK_ID); $this->offset = 0;;
		$this->buffer .= pack("n", $this->evid);
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->x) : strrev(pack("f", $this->x)));
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->y) : strrev(pack("f", $this->y)));
		$this->buffer .= (ENDIANNESS === 0 ? pack("f", $this->z) : strrev(pack("f", $this->z)));
		$this->buffer .= pack("N", $this->data);
	}

}
