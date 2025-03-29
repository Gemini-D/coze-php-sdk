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

namespace Coze;

use JetBrains\PhpStorm\ArrayShape;

class Chat
{
    public function __construct(protected Client $client)
    {
    }

    public function send(
        string $botId,
        string $userId,
        array $messages = [],
        #[ArrayShape([
            'conversation_id' => 'string',
        ])]
        array $extra = []
    ) {
        return $this->client->request('POST', '/v3/chat', [
            'query' => [
                'conversation_id' => $extra['conversation_id'] ?? '',
            ],
            'json' => [
                'bot_id' => $botId,
                'user_id' => $userId,
                'stream' => false,
                'auto_save_history' => true,
                'additional_messages' => $messages,
            ],
        ]);
    }

    public function retrieve(string $chatId, string $conversationId)
    {
        return $this->client->request('GET', '/v3/chat/retrieve', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'chat_id' => $chatId,
                'conversation_id' => $conversationId,
            ],
        ]);
    }

    public function messages(string $chatId, string $conversationId)
    {
        return $this->client->request('GET', '/v3/chat/message/list', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'query' => [
                'chat_id' => $chatId,
                'conversation_id' => $conversationId,
            ],
        ]);
    }
}
