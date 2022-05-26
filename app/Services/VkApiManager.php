<?php


namespace App\Services;


use VK\Client\VKApiClient;

class VkApiManager
{
    protected $vkApiClient;
    protected $accessToken;

    public function __construct(VKApiClient $client)
    {
        $this->vkApiClient = $client;
        $this->accessToken = config('vk.access_token');
    }

    public function getGroupById(string $customName)
    {
        return $this->vkApiClient->groups()->getById($this->accessToken, [
           'group_id' => $customName,
           'fields' => ['members_count']
        ])[0];
    }

    public function getLatestPost($customName, $offset = 0)
    {
        $post = $this->vkApiClient->wall()->get($this->accessToken, [
            'domain' => $customName,
            'count' => 10,
            'offset' => $offset
        ]);

        $post = $post['items'][0];


        if((isset($post['is_pinned']) && $post['is_pinned']) || (isset($post['marked_as_ads']) && $post['marked_as_ads'])) {
            return $this->getLatestPost($customName, 1);
        }

        return $post;
    }

    public function getLatestPosts($customName, $offset = 0, $count = 1)
    {
        $posts = $this->vkApiClient->wall()->get($this->accessToken, [
            'domain' => $customName,
            'count' => $count,
            'offset' => $offset
        ]);

        foreach ($posts['items'] as $post) {

            if((isset($post['is_pinned']) && $post['is_pinned']) || (isset($post['marked_as_ads']) && $post['marked_as_ads'])) {
                return $this->getLatestPosts($customName, 1, $count);
            }
        }



        return $posts;
    }

    public function getPostAttachments(array $post)
    {
        $collection = collect($post['attachments']);

        return $collection->reject(function ($item) {
            return $item['type'] == 'video';
        })
        ->map(function ($item) {//video
            return array_pop($item['photo']['sizes']);
        });
    }

    public function searchPost()
    {

    }

    public function storePost()
    {

    }
}
