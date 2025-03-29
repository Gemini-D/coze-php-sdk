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

class Conversation
{
    public function __construct(protected Client $client)
    {
    }

    public function create(string $botId, array $messages, array $meta): array
    {
        return $this->client->request('POST', '/v1/conversation/create', [
            'json' => [
                'bot_id' => $botId,
                'meta_data' => $meta,
                'messages' => $messages,
            ],
        ]);
    }
}
