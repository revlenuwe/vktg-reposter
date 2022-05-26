<?php


namespace App\Http\Controllers\Commands;


use App\Models\Channel;
use App\Models\Group;
use App\Services\ChannelService;
use App\Services\GroupService;
use Telegram\Bot\Commands\Command;

class BindChannelToGroupCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "bind";

    protected $pattern = "{channel_username} {group_custom_name}";
    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";

    protected $groupService;

    protected $channelService;

    public function __construct(ChannelService $channelService, GroupService $groupService)
    {
        $this->channelService = $channelService;
        $this->groupService = $groupService;
    }

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $channel = $this->channelService->getChannel($this->arguments['channel_username']);
        $group = $this->groupService->getGroup($this->arguments['group_custom_name']);

        if(!$channel || !$group) {
            return $this->replyWithMessage([
                'text' => 'Ups! Channel or Group does not exist, check unique identifiers'
            ]);
        }

        $this->channelService->bindToGroup($channel, $group);

        $this->replyWithMessage([
            'text' => sprintf('<code>%s</code> group and the <code>%s</code> channel are successfully bound', $group->name, $channel->name),
            'parse_mode' => 'html'
        ]);
    }
}
