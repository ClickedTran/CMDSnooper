<?php

namespace cmdsnooper;

use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;

use cmdsnooper\EventListener;

class CmdSnooper extends PluginBase {
	public $snoopers = [];
	public $setting;
	
	public function onEnable(): void{
		@mkdir($this->getDataFolder());
		$this->getLogger()->info("Enabled! Ready to snoop >:D");
		$this->getServer()->getPluginManager()->registerEvents(new EventListener($this), $this);
		$this->setting = new Config($this->getDataFolder() . "settings.yml", Config::YAML, array(
	  	"Console.Logger" => "true",
  		));
	}
	
	 public function onCommand(CommandSender $sender, Command $cmd, string $label, array $args): bool{			
		if(strtolower($cmd->getName()) == "snoop") {
		 	if($sender instanceof Player) {
				if($sender->hasPermission("cmdsnooper.command")) {
					if(!isset($this->snoopers[$sender->getName()])) {
						$sender->sendMessage("§f§l[§cSpy§f]§r§a Spy mode is enabled");
						$this->snoopers[$sender->getName()] = $sender;
						return true;
					} else {
						$sender->sendMessage("§f§l[§cSpy§f]§r§a Spy mode has been turned off");
						unset($this->snoopers[$sender->getName()]);
						return true;
					}
				}
			}
		}
		return true;
	}
}
