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

class ChatTask
{
    /**
     * @param int $id 我方任务ID，用于遍历所有未完成的对话使用，可以是 MySQL 的主键ID
     */
    public function __construct(
        public int $id,
        public string $botId,
        public string $chatId,
        public string $conversationId,
        public bool $isCompleted
    ) {
    }
}
