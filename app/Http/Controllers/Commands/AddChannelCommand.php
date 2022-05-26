<?php


namespace App\Http\Controllers\Commands;


use App\Models\Channel;
use App\Models\Group;
use App\Services\ChannelService;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class AddChannelCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "addChannel";

//    protected $pattern = "{}";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    private $channelService;

    public function __construct(ChannelService $channelService)
    {
        $this->channelService = $channelService;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        if($this->getUpdate()->getChat()->getType() == 'channel') {
            $channel = $this->channelService->storeChannel($this->getUpdate()->getChat());

            if(!$channel) {
                Telegram::sendMessage([
                    'chat_id' => config('telegram.admin_chat_id'),
                    'text' => sprintf('Channel <code>%s</code> already exists', $this->getUpdate()->getChat()->username),
                    'parse_mode' => 'html'
                ]);

                return $this->deleteLastMessage();
            }

            Telegram::sendMessage([
                'chat_id' => config('telegram.admin_chat_id'),
                'text' => sprintf('Channel <code>%s</code> successfully added', $this->getUpdate()->getChat()->username),
                'parse_mode' => 'html'
            ]);

            return $this->deleteLastMessage();
        }
    }

    protected function deleteLastMessage()
    {
        return Telegram::deleteMessage([
            'chat_id' => $this->getUpdate()->getChat()->getId(),
            'message_id' => $this->getUpdate()->getMessage()->getMessageId()
        ]);
    }
}
