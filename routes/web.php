<?php

use App\Http\Controllers\HookController;
use App\Models\Channel;
use App\Models\Group;
use App\Services\RepostManager;
use App\Services\VkApiManager;
use Illuminate\Support\Facades\Route;
use VK\OAuth\VKOAuth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::any('/hook', [HookController::class, 'handle']);
Route::any('/hook/clear', [HookController::class, 'clear']);

Route::get('/check',function (RepostManager $manager) {
//    Telegram::sendPhoto([
//        'chat_id' => 423872982,
//        'photo' => InputFile::create('https://i1.sndcdn.com/artworks-000665872894-090oq5-t500x500.jpg')
//    ]);
//    die();
//    dd(
//        $manager->getPostAttachments($manager->getLatestPost('feitnv', 1))
//    );
    dd(
        $manager->repostRecentPostsMulti(Channel::find(2))
    );
//    $manager->getPostAttachments($manager->getLatestPost('yourprdse'));
//    $channel = Channel::create([
//        'channel_id' => -1001527196839,
//        'channel_username' => 'lucinkaf',
//        'name' => 'lucinka'
//    ]);
//    dd($channel);
//    $channel = Channel::find(2);
////
//    $group = Group::create([
//        'group_id' => rand(15588,5522222),
//        'custom_name' => 'passhunter',
//        'name' => 'passhunter',
//
//    ]);
//    $channel->groups()->sync($group);
////
//    dd($channel->groups);
});

Route::get('/', function () {
    $oauth = new VKOAuth();
    $client_id = 6604546;
    $redirect_uri = '';
////
//    $display = VK\OAuth\VKOAuthDisplay::PAGE;
//////    $scope = [VK\OAuth\Scopes\VKOAuthUserScope::WALL, VK\OAuth\Scopes\VKOAuthUserScope::GROUPS];
//    $scope = [VK\OAuth\Scopes\VKOAuthUserScope::OFFLINE];
//    $state = 'secret_state_code';
////
//    $response = $oauth->getAuthorizeUrl(VK\OAuth\VKOAuthResponseType::CODE, $client_id, $redirect_uri, $display, $scope, $state);

//    $client_secret = 'wfbpISYAH1UTbvhgUSDx';
//    $code = 'f22e2702acbf3641af';
//
//    $response = $oauth->getAccessToken($client_id, $client_secret, $redirect_uri, $code);
//
//    dd($response);

});
