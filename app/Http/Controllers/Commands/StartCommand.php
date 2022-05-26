<?php


namespace App\Http\Controllers\Commands;


use App\Models\User;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start"; //or just name

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $chatId = $this->getUpdate()->getMessage()->getChat()->getId();

        $user = User::where('chat_id', $chatId)->first();

        if(!$user){
            User::create([
                'chat_id' => $chatId,
                'username' => $this->getUpdate()->getMessage()->getChat()->getUsername(),
                'name' => $this->getUpdate()->getMessage()->getChat()->getFirstName(),
            ]);
        }

        $this->replyWithMessage([
            'text' => sprintf('Hi %s',  $this->getUpdate()->getMessage()->getChat()->getUsername())
        ]);
    }
}
