<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Item;
use App\Models\TelegramUser;
use App\Models\User;
use Auth;

class TelegramBotController extends Controller
{
    public function setWebhook() {
        $response = Telegram::setWebhook(['url' => 'https://0da6-85-93-59-208.ngrok-free.app/6348671637:AAEminvDP9BKM0Xh7uAOAUKKHBLjegVwH2w/handleWebhook']);
        dd($response);
    }
    
    public function handle(Request $request) {
        $text = $request['message']['text'];
        $chat_id = $request['message']['chat']['id'];
        switch ($text) {
            case "/start": {
                $username = $request['message']['chat']['username'];

                $token = bin2hex(random_bytes(16));

                $user = TelegramUser::where('username', $username)->first();

                if ($user) {
                    $user->token = $token;
                    $user->save();
                } else {
                    $data = [
                        'username' => $username,
                        'token' => $token,
                    ];
                    TelegramUser::create($data);
                };

                $r = 'Ваш токен: `' . $token . '`';
                
                Telegram::sendMessage(['chat_id' => $chat_id, 'text' => $r, 'parse_mode' => 'MarkdownV2']);
                break;
            }
            case "/list": {
                $username = $request['message']['chat']['username'];

                $user = User::where('telegram', '@' . $username)->first();

                if ($user) {
                    $items = Item::where('user_id', $user->id)->get();
                    $r = "Список:\n";
                    foreach ($items as $value) {
                        $r .= "\t" . $value['data_id'] . '. ' . $value['name'] . "\n";
                    }
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => $r,
                    ]);
                } else {
                    Telegram::sendMessage([
                        'chat_id' => $chat_id,
                        'text' => 'Для начала привяжите свой аккаунт, введя на сайте во вкладке "Профиль" свой токен.'
                    ]);
                }
                break;
            }
            default: {
                Telegram::sendMessage([
                    'chat_id' => $chat_id,
                    'text' => "Список команд:\n\t/start - получить токен\n\t/list - вывести список предметов с сайта"
                ]);
            }
        }
        return response(null, 200);
    }

    public function tryAddToken(Request $request) {
        $token = $request->input('token');
        $telegramUser = TelegramUser::where('token', $token)->first();

        if (!$telegramUser || $telegramUser->user_id) return ['valid' => false];

        $user = Auth::user();

        $user->telegram = '@' . $telegramUser['username'];
        $user->save();

        $telegramUser->user_id = $user->id;
        $telegramUser->save();

        return ['valid' => true];
    }
}
