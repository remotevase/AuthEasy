<?php



namespace AuthEasy\provider;

use pocketmine\IPlayer;
use pocketmine\utils\Config;
use AuthEasy\AuthEasy;

interface DataProvider{

	/**
	 * @param IPlayer $player
	 *
	 * @return array, or null if it does not exist
	 */
	public function getPlayer(IPlayer $player);

	/**
	 * @param IPlayer $player
	 *
	 * @return bool
	 */
	public function isPlayerRegistered(IPlayer $player);

	/**
	 * @param IPlayer $player
	 * @param string  $hash
	 *
	 * @return array, or null if error happened
	 */
	public function registerPlayer(IPlayer $player, $hash);

	/**
	 * @param IPlayer $player
	 */
	public function unregisterPlayer(IPlayer $player);

	/**
	 * @param IPlayer $player
	 * @param array   $config
	 */
	public function savePlayer(IPlayer $player, array $config);

	/**
	 * @param IPlayer $player
	 * @param string  $lastId
	 * @param int     $loginDate
	 */
	public function updatePlayer(IPlayer $player, $lastId = null, $loginDate = null);

	public function close();
}
