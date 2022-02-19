<?php

namespace SandhyR\AntiCrown;

use pocketmine\scheduler\AsyncTask;

class QueryAsyncTask extends AsyncTask{

    /** @var string */
    private string $player;

    public function __construct(string $player)
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
        if(in_array(strtolower($this->player), array_merge($result["officers"], $result["members"], [$result["leader"]]))){
            Main::getInstance()->kickPlayer($this->player);
        }
    }
}
