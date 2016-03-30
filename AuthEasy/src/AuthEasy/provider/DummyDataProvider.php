<?php



namespace AuthEasy\provider;

use pocketmine\IPlayer;
use pocketmine\utils\Config;
use AuthEasy\AuthEasy;

class DummyDataProvider implements DataProvider{

	/** @var AuthEasy */
	protected $plugin;

	public function __construct(AuthEasy $plugin){
		$this->plugin = $plugin;
	}

	public function getPlayer(IPlayer $player){
		return null;
	}

	public function isPlayerRegistered(IPlayer $player){
		return false;
	}

	public function registerPlayer(IPlayer $player, $hash){
		return null;
	}

	public function unregisterPlayer(IPlayer $player){

	}

	public function savePlayer(IPlayer $player, array $config){

	}

	public function updatePlayer(IPlayer $player, $lastIP = null, $loginDate = null){

	}

	public function close(){

	}
}
