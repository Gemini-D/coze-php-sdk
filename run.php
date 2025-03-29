<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Coze\Client;
use Coze\Token;

require __DIR__ . '/vendor/autoload.php';

$token = new Token(file_get_contents('token.txt'));

$client = new Client($token);

$res = $client->chat->send('7476014622794154010', '123', [
    [
        'content' => '请给我一份上海宝山的房源数据',
        'content_type' => 'text',
        'role' => 'user',
        'type' => 'question',
    ],
]);

var_dump($res);

$chatId = $res['data']['id'];
$conversationId = $res['data']['conversation_id'];

sleep(1);

$res = $client->chat->retrieve($chatId, $conversationId);
var_dump($res);
