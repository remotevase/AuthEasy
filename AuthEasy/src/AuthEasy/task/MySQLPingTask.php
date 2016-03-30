<?php



namespace AuthEasy\task;

use pocketmine\scheduler\PluginTask;
use AuthEasy\AuthEasy;

class MySQLPingTask extends PluginTask{

	/** @var \mysqli */
	private $database;

	public function __construct(AuthEasy $owner, \mysqli $database){
		parent::__construct($owner);
		$this->database = $database;
	}

	public function onRun($currentTick){
		$this->database->ping();
	}
}
