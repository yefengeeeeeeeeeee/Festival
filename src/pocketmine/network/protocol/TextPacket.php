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
use function count;
use function ord;

class TextPacket extends DataPacket{
	const NETWORK_ID = Info::TEXT_PACKET;

	const TYPE_RAW = 0;
	const TYPE_CHAT = 1;
	const TYPE_TRANSLATION = 2;
	const TYPE_POPUP = 3;
	const TYPE_TIP = 4;

	public $type;
	public $source;
	public $message;
	public $parameters = [];

	public function decode(){
		$this->type = ord($this->get(1));
		switch($this->type){
			case self::TYPE_CHAT:
				$this->source = $this->getString();
			case self::TYPE_RAW:
			case self::TYPE_POPUP:
			case self::TYPE_TIP:
				$this->message = $this->getString();
				break;

			case self::TYPE_TRANSLATION:
				$this->message = $this->getString();
				$count = ord($this->get(1));
				for($i = 0; $i < $count; ++$count){
					$this->parameters[] = $this->getString();
				}
		}
	}

	public function encode(){
		$this->buffer = chr(self::NETWORK_ID); $this->offset = 0;;
		$this->buffer .= chr($this->type);
		switch($this->type){
			case self::TYPE_CHAT:
				$this->putString($this->source);
			case self::TYPE_RAW:
			case self::TYPE_POPUP:
			case self::TYPE_TIP:
				$this->putString($this->message);
				break;

			case self::TYPE_TRANSLATION:
				$this->putString($this->message);
				$this->buffer .= chr(count($this->parameters));
				foreach($this->parameters as $p){
					$this->putString($p);
				}
		}
	}

}
