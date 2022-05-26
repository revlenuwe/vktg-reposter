<?php


namespace App\Http\Controllers\Commands;


use App\Models\Group;
use App\Services\GroupService;
use App\Services\VkApiManager;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class AddGroupCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "addGroup";

    protected $pattern = '{custom_name}';

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    protected $groupService;

    protected $vkApiManager;

    public function __construct(GroupService $groupService, VkApiManager $manager)
    {
        $this->groupService = $groupService;
        $this->vkApiManager = $manager;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $groupInfo = $this->vkApiManager->getGroupById($this->arguments['custom_name']);

        $group = $this->groupService->storeGroup($groupInfo);

        if(!$group) {
            return Telegram::sendMessage([
                'chat_id' => config('telegram.admin_chat_id'),
                'text' => sprintf('Group <code>%s (%s)</code> already exists', $groupInfo['name'], $groupInfo['screen_name']),
                'parse_mode' => 'html'
            ]);
        }

        Telegram::sendMessage([
            'chat_id' => config('telegram.admin_chat_id'),
            'text' => sprintf('Group <code>%s (%s)</code> successfully added', $groupInfo['name'], $groupInfo['screen_name']),
            'parse_mode' => 'html'
        ]);
    }
}
