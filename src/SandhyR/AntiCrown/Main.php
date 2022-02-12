<?php

namespace SandhyR\AntiCrown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Internet;

class Main extends PluginBase implements Listener{

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onLogin(PlayerPreLoginEvent $event){
        $context=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $api = json_decode(file_get_contents("https://player.venitymc.com/api/v1/guild/crown", false ,stream_context_create($context)));
        if(in_array(strtolower($event->getPlayerInfo()->getUsername()), array_merge($api["officers"], $api["members"], [$api["leader"]]))){
            $event->setKickReason(PlayerPreLoginEvent::KICK_REASON_PLUGIN, "Kron");
        }
    }
}