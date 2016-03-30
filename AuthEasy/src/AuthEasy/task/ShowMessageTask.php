<?php



namespace AuthEasy\task;

use pocketmine\Player;
use pocketmine\scheduler\PluginTask;
use pocketmine\utils\TextFormat;
use AuthEasy\AuthEasy;

class ShowMessageTask extends PluginTask{

	/** @var Player[] */
	private $playerList = [];

	public function __construct(AuthEasy $plugin){
		parent::__construct($plugin);
	}

	/**
	 * @return AuthEasy
	 */
	public function getPlugin(){
		return $this->owner;
	}

	public function addPlayer(Player $player){
		$this->playerList[$player->getUniqueId()] = $player;
	}

	public function removePlayer(Player $player){
		unset($this->playerList[$player->getUniqueId()]);
	}

	public function onRun($currentTick){
		$plugin = $this->getPlugin();
		if($plugin->isDisabled()){
			return;
		}

		foreach($this->playerList as $player){
			$player->sendPopup(TextFormat::ITALIC . TextFormat::GRAY . $this->getPlugin()->getMessage("join.popup"));
		}
	}

}
