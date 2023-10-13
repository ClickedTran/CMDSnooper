<?php
declare(strict_types=1);
namespace ClickedTran\CMDSnooper;

use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use ClickedTran\CMDSnooper\CMDSnooper;
use pocketmine\player\Player;

class EventListener implements Listener {
	public $plugin;
	public function __construct(CmdSnooper $plugin) {
		$this->plugin = $plugin;
	}

	public function getPlugin() {
		return $this->plugin;
	}
	
	public function onCmnd(CommandEvent $event): void{
	  $sender = $event->getSender();
		$msg = $event->getCommand();
		if($this->getPlugin()->setting->get("Console.Logger") == "true") {
		  if($sender instanceof Player){
		   if($msg[0] == "login" or $msg[0] == "log" or $msg[0] == "register" or $msg[0] == "reg"){
		     $this->getPlugin()->getLogger()->info($sender->getName() . "§a Covered for security reasons!");
		     return;
		   }
		   $this->getPlugin()->getLogger()->info("§f§l[§cSpy§f]§r§a ". $sender->getName() . " §e➼§a /" . $msg);
		   }
	  	}
			
			if(!empty($this->getPlugin()->snoopers)) {
				foreach($this->getPlugin()->snoopers as $snooper) {
			    if($sender instanceof Player){
			      if($msg[0] == "login" or $msg[0] == "log" or $msg[0] == "register" or $msg[0] == "reg"){
		           $this->getPlugin()->getLogger()->info($sender->getName() . "§a Covered for security reasons!");
		           return;
		         }
						 $snooper->sendMessage("§f§l[§cSpy§f]§r§a " . $sender->getName() . " §e➼§a /" . $msg);
				  }
				}
	    }		
    }
  }
