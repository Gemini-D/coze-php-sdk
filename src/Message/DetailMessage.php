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

namespace Coze\Message;

use Hyperf\Contract\JsonDeSerializable;
use JsonSerializable;

class DetailMessage implements JsonDeSerializable, JsonSerializable
{
    public function __construct(
        public string $botId,
        public string $chatId,
        public string $content,
        public string $contentType,
        public string $conversationId,
        public string $id,
        public string $role,
        public string $type,
        public int $createdAt = 0,
        public int $updatedAt = 0,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['bot_id'],
            $data['chat_id'],
            $data['content'],
            $data['content_type'],
            $data['conversation_id'],
            $data['id'],
            $data['role'],
            $data['type'],
            $data['created_at'],
            $data['updated_at'],
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'bot_id' => $this->botId,
            'chat_id' => $this->chatId,
            'content' => $this->content,
            'content_type' => $this->contentType,
            'conversation_id' => $this->conversationId,
            'id' => $this->id,
            'role' => $this->role,
            'type' => $this->type,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
