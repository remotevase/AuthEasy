<?php



namespace AuthEasy\event;

use pocketmine\event\Cancellable;
use pocketmine\IPlayer;
use AuthEasy\AuthEasy;

class PlayerUnregisterEvent extends AuthEasyEvent implements Cancellable{
	public static $handlerList = null;

	/** @var IPlayer */
	private $player;

	/**
	 * @param AuthEasy $plugin
	 * @param IPlayer    $player
	 */
	public function __construct(AuthEasy $plugin, IPlayer $player){
		$this->player = $player;
		parent::__construct($plugin);
	}

	/**
	 * @return IPlayer
	 */
	public function getPlayer(){
		return $this->player;
	}
}
