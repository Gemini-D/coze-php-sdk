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
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class RetrieveMessage extends RawData implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param string $status created：对话已创建。
     *                       in_progress：智能体正在处理中。
     *                       completed：智能体已完成处理，本次对话结束。
     *                       failed：对话失败。
     *                       requires_action：对话中断，需要进一步处理。
     *                       canceled：对话已取消。
     */
    public function __construct(
        public string $botId,
        public string $chatId,
        public string $conversationId,
        public string $status,
        #[ArrayShape([
            'input_count' => 'int',
            'output_count' => 'int',
            'token_count' => 'int',
        ])]
        public array $usage = [],
        public int $createdAt = 0,
        public int $completedAt = 0,
    ) {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        return new static(
            $data['bot_id'],
            $data['id'],
            $data['conversation_id'],
            $data['status'],
            $data['usage'] ?? [],
            $data['created_at'],
            $data['completed_at'] ?? 0,
        );
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id' => $this->chatId,
            'bot_id' => $this->botId,
            'conversation_id' => $this->conversationId,
            'status' => $this->status,
            'usage' => $this->usage,
            'created_at' => $this->createdAt,
            'completed_at' => $this->completedAt,
        ];
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
