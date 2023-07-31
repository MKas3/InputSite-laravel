<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\TelegramUser;
use Auth;

class TelegramBotController extends Controller
{
    public function setWebhook() {
        $response = Telegram::setWebhook(['url' => 'https://725b-85-93-59-208.ngrok-free.app/6348671637:AAEminvDP9BKM0Xh7uAOAUKKHBLjegVwH2w/handleWebhook']);
        dd($response);
    }
    
    public function handle(Request $request) {
        $text = $request['message']['text'];
        $chat_id = $request['message']['chat']['id'];
        if($text === "/start"){
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
        }
        return response(null, 200);
    }

    public function tryAddToken(Request $request) {
        $token = $request->input('token');
        $telegramUser = TelegramUser::where('token', $token)->first();

        if (!$telegramUser) return ['valid' => false];

        $user = Auth::user();

        $user->telegram = '@' . $telegramUser['username'];
        $user->save();

        return ['valid' => true];
    }
}
