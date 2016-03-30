<?php



namespace AuthEasy\provider;

use pocketmine\IPlayer;
use AuthEasy\AuthEasy;
use AuthEasy\task\MySQLPingTask;

class MySQLDataProvider implements DataProvider{

	/** @var AuthEasy */
	protected $plugin;

	/** @var \mysqli */
	protected $database;


	public function __construct(AuthEasy $plugin){
		$this->plugin = $plugin;
		$config = $this->plugin->getConfig()->get("dataProviderSettings");

		if(!isset($config["host"]) or !isset($config["user"]) or !isset($config["password"]) or !isset($config["database"])){
			$this->plugin->getLogger()->critical("Invalid MySQL settings");
			$this->plugin->setDataProvider(new DummyDataProvider($this->plugin));
			return;
		}

		$this->database = new \mysqli($config["host"], $config["user"], $config["password"], $config["database"], isset($config["port"]) ? $config["port"] : 3306);
		if($this->database->connect_error){
			$this->plugin->getLogger()->critical("Couldn't connect to MySQL: ". $this->database->connect_error);
			$this->plugin->setDataProvider(new DummyDataProvider($this->plugin));
			return;
		}

		$resource = $this->plugin->getResource("mysql.sql");
		$this->database->query(stream_get_contents($resource));
		fclose($resource);

		$this->plugin->getServer()->getScheduler()->scheduleRepeatingTask(new MySQLPingTask($this->plugin, $this->database), 600); //Each 30 seconds
		$this->plugin->getLogger()->info("Connected to MySQL server");
	}

	public function getPlayer(IPlayer $player){
		$name = trim(strtolower($player->getName()));

		$result = $this->database->query("SELECT * FROM AuthEasy_players WHERE name = '" . $this->database->escape_string($name)."'");

		if($result instanceof \mysqli_result){
			$data = $result->fetch_assoc();
			$result->free();
			if(isset($data["name"]) and strtolower($data["name"]) === $name){
				unset($data["name"]);
				return $data;
			}
		}

		return null;
	}

	public function isPlayerRegistered(IPlayer $player){
		return $this->getPlayer($player) !== null;
	}

	public function unregisterPlayer(IPlayer $player){
		$name = trim(strtolower($player->getName()));
		$this->database->query("DELETE FROM AuthEasy_players WHERE name = '" . $this->database->escape_string($name)."'");
	}

	public function registerPlayer(IPlayer $player, $hash){
		$name = trim(strtolower($player->getName()));
		$data = [
			"registerdate" => time(),
			"logindate" => time(),
			"lastip" => null,
			"hash" => $hash
		];

		$this->database->query("INSERT INTO AuthEasy_players
			(name, registerdate, logindate, lastip, hash)
			VALUES
			('".$this->database->escape_string($name)."', ".intval($data["registerdate"]).", ".intval($data["logindate"]).", '', '".$hash."')
		");

		return $data;
	}

	public function savePlayer(IPlayer $player, array $config){
		$name = trim(strtolower($player->getName()));
		$this->database->query("UPDATE AuthEasy_players SET registerdate = ".intval($config["registerdate"]).", logindate = ".intval($config["logindate"]).", lastip = '".$this->database->escape_string($config["lastip"])."', hash = '".$this->database->escape_string($config["hash"])."' WHERE name = '".$this->database->escape_string($name)."'");

	}

	public function updatePlayer(IPlayer $player, $lastIP = null, $loginDate = null){
		$name = trim(strtolower($player->getName()));
		if($lastIP !== null){
			$this->database->query("UPDATE AuthEasy_players SET lastip = '".$this->database->escape_string($lastIP)."' WHERE name = '".$this->database->escape_string($name)."'");
		}
		if($loginDate !== null){
			$this->database->query("UPDATE AuthEasy_players SET logindate = ".intval($loginDate)." WHERE name = '".$this->database->escape_string($name)."'");
		}
	}

	public function close(){
		$this->database->close();
	}
}
