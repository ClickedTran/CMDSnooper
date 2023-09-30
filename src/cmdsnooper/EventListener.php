<?php

namespace cmdsnooper;

use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use cmdsnooper\CmdSnooper;
use pocketmine\player\Player;
use pocketmine\Server;

class EventListener implements Listener {	
	public function onCmnd(CommandEvent $event): void{
	  $sender = $event->getSender();
		$msg = $event->getCommand();
		
		if($this->getPlugin()->setting->get("Console.Logger") == "true") {
		  if($sender instanceof Player){
		   if($msg == "login" or $msg == "log" or $msg == "register" or $msg == "reg"){
		     Server::getInstance()->getLogger()->info($sender->getName() . "§a Covered for security reasons!");
		     return;
		   }
		   Server::getInstance()->getLogger()->info("§f§l[§cSpy§f]§r§a ". $sender->getName() . " §e➼§a /" . $msg);
		   }
	  	}
			
			if(!empty($this->getPlugin()->snoopers)) {
				foreach($this->getPlugin()->snoopers as $snooper) {
			    if($sender instanceof Player){
			      if($msg == "login" or $msg == "log" or $msg == "register" or $msg == "reg"){
		           Server::getInstance()->getLogger()->info($sender->getName() . "§a Covered for security reasons!");
		           return;
		         }
						 $snooper->sendMessage("§f§l[§cSpy§f]§r§a " . $sender->getName() . " §e➼§a /" . $msg);
				  }
				}
	    }		
    }
  }
