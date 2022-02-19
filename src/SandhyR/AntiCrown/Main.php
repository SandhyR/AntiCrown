<?php

namespace SandhyR\AntiCrown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\player\Player;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    private static $instance;

    public function onEnable(): void
    {
        self::$instance = $this;
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onLogin(PlayerLoginEvent $event){
        $this->getServer()->getAsyncPool()->submitTask(new QueryAsyncTask($event->getPlayer()->getName(), $this));
    }

    public function kickPlayer(string $username){
        $player = $this->getServer()->getPlayerExact($username);
        if($player instanceof Player){
            $player->kick("Kron");
        }
    }

    public static function getInstance(): self{
        return self::$instance;
}
}