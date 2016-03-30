<?php



namespace AuthEasy\event;

use pocketmine\event\Cancellable;
use pocketmine\Player;
use AuthEasy\AuthEasy;

class PlayerDeauthenticateEvent extends AuthEasyEvent implements Cancellable{
	public static $handlerList = null;


	/** @var Player */
	private $player;

	/**
	 * @param AuthEasy $plugin
	 * @param Player     $player
	 */
	public function __construct(AuthEasy $plugin, Player $player){
		$this->player = $player;
		parent::__construct($plugin);
	}

	/**
	 * @return Player
	 */
	public function getPlayer(){
		return $this->player;
	}
}
