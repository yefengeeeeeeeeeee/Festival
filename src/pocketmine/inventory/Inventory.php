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

/**
 * Handles the creation of virtual inventories or mapped to an InventoryHolder
 */
namespace pocketmine\inventory;

use pocketmine\item\Item;
use pocketmine\Player;

interface Inventory{
	const MAX_STACK = 64;

	public function getSize();

	public function getMaxStackSize();

	/**
	 * @param int $size
	 */
	public function setMaxStackSize($size);

	public function getName();

	public function getTitle();

	/**
	 * @param int $index
	 *
	 * @return Item
	 */
	public function getItem($index);

	/**
	 * Puts an Item in a slot.
	 * If a plugin refuses the update or $index is invalid, it'll return false
	 * If a source Player is specified, it won't send a Inventory update to it
	 *
	 * @param int    $index
	 *
	 * @return bool
	 */
	public function setItem($index, Item $item);

	/**
	 * Stores the given Items in the inventory. This will try to fill
	 * existing stacks and empty slots as well as it can.
	 *
	 * Returns the Items that did not fit.
	 *
	 *
	 * @return Item[]
	 */
	public function addItem(...$slots);

	/**
	 * Checks if a given Item can be added to the inventory
	 *
	 *
	 * @return bool
	 */
	public function canAddItem(Item $item);

	/**
	 * Removes the given Item from the inventory.
	 * It will return the Items that couldn't be removed.
	 *
	 *
	 * @return Item[]
	 */
	public function removeItem(...$slots);

	/**
	 * @return Item[]
	 */
	public function getContents();

	/**
	 * @param Item[] $items
	 */
	public function setContents(array $items);

	/**
	 * @param Player|Player[] $target
	 */
	public function sendContents($target);

	/**
	 * @param int             $index
	 * @param Player|Player[] $target
	 */
	public function sendSlot($index, $target);

	/**
	 * Checks if the inventory contains any Item with the same material data.
	 * It will check id, amount, and metadata (if not null)
	 *
	 *
	 * @return bool
	 */
	public function contains(Item $item);

	/**
	 * Will return all the Items that has the same id and metadata (if not null).
	 * Won't check amount
	 *
	 *
	 * @return Item[]
	 */
	public function all(Item $item);

	/**
	 * Will return the first slot has the same id and metadata (if not null) as the Item.
	 * -1 if not found, will check amount
	 *
	 *
	 * @return int
	 */
	public function first(Item $item);

	/**
	 * Returns the first empty slot, or -1 if not found
	 *
	 * @return int
	 */
	public function firstEmpty();

	/**
	 * Will remove all the Items that has the same id and metadata (if not null)
	 *
	 */
	public function remove(Item $item);

	/**
	 * Will clear a specific slot
	 *
	 * @param int    $index
	 *
	 * @return bool
	 */
	public function clear($index);

	/**
	 * Clears all the slots
	 */
	public function clearAll();

	/**
	 * Gets all the Players viewing the inventory
	 * Players will view their inventory at all times, even when not open.
	 *
	 * @return Player[]
	 */
	public function getViewers();

	/**
	 * @return InventoryType
	 */
	public function getType();

	/**
	 * @return InventoryHolder
	 */
	public function getHolder();

	public function onOpen(Player $who);

	/**
	 * Tries to open the inventory to a player
	 *
	 *
	 * @return bool
	 */
	public function open(Player $who);

	public function close(Player $who);

	public function onClose(Player $who);

	/**
	 * @param int    $index
	 * @param Item   $before
	 */
	public function onSlotChange($index, $before);
}
