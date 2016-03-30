<?php



namespace AuthEasy\event;

use pocketmine\event\plugin\PluginEvent;
use AuthEasy\AuthEasy;

abstract class AuthEasyEvent extends PluginEvent{

	/**
	 * @param AuthEasy $plugin
	 */
	public function __construct(AuthEasy $plugin){
		parent::__construct($plugin);
	}
}
