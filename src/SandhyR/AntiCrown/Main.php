<?php

namespace SandhyR\AntiCrown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerPreLoginEvent;
use pocketmine\plugin\PluginBase;
use VenityNetwork\CurlLib\CurlLib;
use VenityNetwork\CurlLib\CurlResponse;

class Main extends PluginBase implements Listener{

    public function onEnable(): void
    {
        if(!class_exists(CurlLib::class)){
            throw new \ErrorException("Install CurlLib from https://github.com/VenityNetwork/CurlLib");
        }
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onPreLogin(PlayerPreLoginEvent $event){
        $url = "https://player.venitymc.com/api/v1/guild/crown";
        $headers = [];
        $curlOpts = [];
        $curl = CurlLib::init($this, 1);
        $curl->get($url, $headers, $curlOpts, function(CurlResponse $response) use ($event) {
            $result = json_decode($response->getBody(), true);
            if(in_array(strtolower($event->getPlayerInfo()->getUsername()), array_merge($result["officers"], $result["members"], [$result["leader"]]))){
                $event->setKickReason(PlayerPreLoginEvent::KICK_REASON_PLUGIN, "Kron");
            }
        });
    }
}