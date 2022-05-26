<?php


namespace App\Services;


use App\Models\Channel;
use Illuminate\Support\Collection;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class RepostManager
{
    protected $vkApiManager;

    protected $groupService;

    public function __construct(VkApiManager $vkApiManager, GroupService $groupService)
    {
        $this->vkApiManager = $vkApiManager;
        $this->groupService = $groupService;
    }

    public function massRepost()
    {
        $channels = Channel::all();

        $channels->each(function ($channel) {
            $this->repostRecentPosts($channel);
        });
    }

    public function repostRecentPosts(Channel $channel)
    {
        $posts = $this->parseRecentPosts($channel);

        if($posts->isEmpty()) {
            return false;
        }

        return $posts->each(function ($item) use ($channel) {
           Telegram::sendPhoto([
               'chat_id' => $channel->channel_id,
               'photo' => InputFile::create($item)
           ]);
        });
    }

    public function parseRecentPosts(Channel $channel)
    {
        $groups = $channel->groups;

        $posts = $groups->map(function ($item) {
            $postInfo = $this->vkApiManager->getLatestPost($item->custom_name);

            $post = $this->groupService->storeGroupPost($item, $postInfo);

            if($post) {
                $attachments = $this->vkApiManager->getPostAttachments($postInfo);

                return $attachments->map(function ($item) {
                    return $item['url'];
                });
            }
        })->flatten();

        return $this->clearExcess($posts);
    }

    public function parseRecentPostsMulti(Channel $channel)
    {
        $groups = $channel->groups;

        $posts = $groups->map(function ($item) {
            $postsInfo = $this->vkApiManager->getLatestPosts($item->custom_name, 0, 50);

//            $post = $this->groupService->storeGroupPost($item, $postInfo);
            $postsInfo = collect($postsInfo['items']);

            return $postsInfo->map(function ($post) {
                $attachments = $this->vkApiManager->getPostAttachments($post);

                return $attachments->map(function ($item) {
                    return $item['url'];
                });
            });

        })->flatten();

        return $this->clearExcess($posts);
    }

    public function repostRecentPostsMulti(Channel $channel)
    {
        $posts = $this->parseRecentPostsMulti($channel);

        if($posts->isEmpty()) {
            return false;
        }

        return $posts->each(function ($item) use ($channel) {
            Telegram::sendPhoto([
                'chat_id' => $channel->channel_id,
                'photo' => InputFile::create($item)
            ]);
        });
    }

    private function clearExcess(Collection $items)
    {
        return $items->reject(function ($item)  {
            return !$item;
        });
    }
}
