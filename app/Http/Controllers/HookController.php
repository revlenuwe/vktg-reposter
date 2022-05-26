<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Objects\Chat;

class HookController extends Controller
{
    public const TOKEN = 'd7297f33cc4a3089636fbba80ed585ddb3d97dd8174e4647200507c1277722f3f1a53310e94b6e28fe7d4';

    public function handle()
    {
        $update = Telegram::commandsHandler(true);

        if($update->getChat()->getType() == 'private') {
            $user = User::where('chat_id', $update->getChat()->id)->first();

            $user->messages()->create([
                'chat_update_id' => $update->updateId,
                'chat_message_id' => $update->getMessage()->messageId,
                'text' => $update->getMessage()->text,
            ]);
        }

        return response()->json([
            'status' => 'ok'
        ]);
//        $vk = new VKApiClient();
//        $res = $vk->wall()->get(self::TOKEN, [
//            'domain' => 'nekrozz1',
//            'count' => 1,
//            'offset' => 2
//        ]);
//
//        $postText = $res['items'][0]['text'];
//
//        $attachments = collect($res['items'][0]['attachments']);
//
//        $photos = $attachments->map(function ($item) {
//           return array_pop($item['photo']['sizes']);
//        });
//
//        $last = $photos->count();
//
//        $photos->each(function ($item, $key) use ($last, $postText) {
//            Telegram::sendPhoto([
//                'chat_id' => 423872982,
//                'photo' => InputFile::create($item['url']),
//                'caption' => $key == $last ?: $postText
//            ]);
//        });
    }

    public function clear()
    {
        return response()->json([
            'status' => 'ok'
        ]);
    }
}
