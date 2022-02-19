<?php

namespace SandhyR\AntiCrown;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\plugin\PluginBase;

class Main extends PluginBase implements Listener{

    public function onEnable(): void
    {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onLogin(PlayerLoginEvent $event){
        $this->getServer()->getAsyncPool()->submitTask(new QueryAsyncTask($event->getPlayer()));
    }
}