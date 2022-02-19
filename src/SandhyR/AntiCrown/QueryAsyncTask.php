<?php

namespace SandhyR\AntiCrown;

use pocketmine\player\Player;
use pocketmine\scheduler\AsyncTask;

class QueryAsyncTask extends AsyncTask{

    /** @var Player */
    private Player $player;

    public function __construct(Player $player)
    {
        $this->player = $player;
    }

    public function onRun(): void
    {
        $context=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );
        $api = json_decode(file_get_contents("https://player.venitymc.com/api/v1/guild/crown", false ,stream_context_create($context)), true);
        $this->setResult($api);
    }

    public function onCompletion(): void
    {
        $result = $this->getResult();
        if(in_array(strtolower($this->player->getName()), array_merge($result["officers"], $result["members"], [$result["leader"]]))){
            $this->player->kick("Kron");
        }
    }
}
