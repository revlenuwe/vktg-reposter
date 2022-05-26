<?php


namespace App\Services;


use App\Models\Channel;
use Telegram\Bot\Objects\Chat;

class ChannelService
{

    public function getChannel(string $channelUsername)
    {
        $channel = Channel::where('channel_username', $channelUsername)->first();

        if(!$channel) {
            return false;
        }

        return $channel;
    }

    public function storeChannel(Chat $data)
    {
        if(!$this->getChannel($data->id)){
            return false;
        }

        return Channel::create([
            'channel_id' => $data->id,
            'channel_username' => $data->username,
            'name' => $data->title
        ]);
    }

    public function bindToGroup($channel, $group)
    {
        return $channel->groups()->sync($group, false);
    }
}
