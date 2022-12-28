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

namespace pocketmine\level\format\anvil;

use pocketmine\level\format\FullChunk;
use pocketmine\level\format\mcregion\McRegion;
use pocketmine\level\Level;
use pocketmine\nbt\tag\Byte;
use pocketmine\nbt\tag\ByteArray;
use pocketmine\nbt\tag\Compound;
use pocketmine\utils\ChunkException;

class Anvil extends McRegion{

	/** @var RegionLoader[] */
	protected $regions = [];

	/** @var Chunk[] */
	protected $chunks = [];

	public static function getProviderName(){
		return "anvil";
	}

	public static function getProviderOrder(){
		return self::ORDER_YZX;
	}

	public static function usesChunkSection(){
		return \true;
	}

	public static function isValid($path){
		$isValid = (\file_exists($path . "/level.dat") and \is_dir($path . "/region/"));

		if($isValid){
			$files = \glob($path . "/region/*.mc*");
			foreach($files as $f){
				if(\strpos($f, ".mcr") !== \false){ //McRegion
					$isValid = \false;
					break;
				}
			}
		}

		return $isValid;
	}

	public function requestChunkTask($x, $z){
		return new ChunkRequestTask($this->getLevel(), $this->getChunk($x, $z, \true));
	}

	/**
	 * @param $x
	 * @param $z
	 *
	 * @return RegionLoader
	 */
	protected function getRegion($x, $z){
		return isset($this->regions[$index = ((($x) & 0xFFFFFFFF) << 32) | (( $z) & 0xFFFFFFFF)]) ? $this->regions[$index] : \null;
	}

	/**
	 * @param int  $chunkX
	 * @param int  $chunkZ
	 * @param bool $create
	 *
	 * @return Chunk
	 */
	public function getChunk($chunkX, $chunkZ, $create = \false){
		return parent::getChunk($chunkX, $chunkZ, $create);
	}

	public function setChunk($chunkX, $chunkZ, FullChunk $chunk){
		if(!($chunk instanceof Chunk)){
			throw new ChunkException("Invalid Chunk class");
		}

		$chunk->setProvider($this);

		self::getRegionIndex($chunkX, $chunkZ, $regionX, $regionZ);
		$this->loadRegion($regionX, $regionZ);

		$chunk->setX($chunkX);
		$chunk->setZ($chunkZ);
		$this->chunks[((($chunkX) & 0xFFFFFFFF) << 32) | (( $chunkZ) & 0xFFFFFFFF)] = $chunk;
	}

	public function getEmptyChunk($chunkX, $chunkZ){
		return Chunk::getEmptyChunk($chunkX, $chunkZ, $this);
	}

	public static function createChunkSection($Y){
		return new ChunkSection(new Compound("", [
			"Y" => new Byte("Y", $Y),
			"Blocks" => new ByteArray("Blocks", \str_repeat("\x00", 4096)),
			"Data" => new ByteArray("Data", \str_repeat("\x00", 2048)),
			"SkyLight" => new ByteArray("SkyLight", \str_repeat("\xff", 2048)),
			"BlockLight" => new ByteArray("BlockLight", \str_repeat("\x00", 2048))
		]));
	}

	public function isChunkGenerated($chunkX, $chunkZ){
		if(($region = $this->getRegion($chunkX >> 5, $chunkZ >> 5)) !== \null){
			return $region->chunkExists($chunkX - $region->getX() * 32, $chunkZ - $region->getZ() * 32) and $this->getChunk($chunkX - $region->getX() * 32, $chunkZ - $region->getZ() * 32, \true)->isGenerated();
		}

		return \false;
	}

	protected function loadRegion($x, $z){
		if(isset($this->regions[$index = ((($x) & 0xFFFFFFFF) << 32) | (( $z) & 0xFFFFFFFF)])){
			return \true;
		}

		$this->regions[$index] = new RegionLoader($this, $x, $z);

		return \true;
	}
}
