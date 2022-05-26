<?php


namespace App\Services;


use App\Models\Group;

class GroupService
{

    public function getGroup(string $customName)
    {
        $channel = Group::where('custom_name', $customName)->first();

        if(!$channel) {
            return false;
        }

        return $channel;
    }

    public function storeGroup(array $data)
    {
        if($this->getGroup($data['id'])){
            return false;
        }//think

        return Group::create([
            'group_id' => $data['id'],
            'custom_name' => $data['screen_name'],
            'name' => $data['name'],
            'is_closed' => $data['is_closed'],
            'group_type' => $data['type']
        ]);
    }

    public function storeGroupPost(Group $group, array $data)//to service
    {
        $post = $group->posts()->where('post_id', $data['id'])->first();

        if($post) {
            return false;
        }

        return $group->posts()->create([
            'post_id' => $data['id'],
            'post_type' => $data['post_type'],
            'text' => $data['text']
        ]);
    }

//    public function bindToChannel($group, $channel)
//    {
//        return $group->channels()->sync($channel);
//    }
}
