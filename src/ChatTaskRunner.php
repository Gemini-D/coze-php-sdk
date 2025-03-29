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

abstract class ChatTaskRunner
{
    public function __construct(public Client $client)
    {
    }

    /**
     * 根据ID检索未完成的任务，例如
     * SELECT id, bot_id, chat_id, conversation_id, is_completed FROM `chat_task` WHERE id > 0 AND is_completed = 1 ORDER BY id ASC LIMIT 100;.
     * @return ChatTask[]
     */
    abstract public function scroll(int $id): array;

    /**
     * 定时筛选.
     */
    public function run(): void
    {
        $id = 0;
        while (true) {
            $tasks = $this->scroll($id);
            if (! $tasks) {
                break;
            }

            foreach ($tasks as $task) {
                $id = $task->id;
                try {
                    if (! $this->lock($id)) {
                        continue;
                    }

                    $retrieved = $this->client->chat->retrieve($task->chatId, $task->conversationId);

                    $task->isCompleted = $retrieved->isCompleted();

                    $this->save($task);
                } finally {
                    $this->unlock($id);
                }
            }
        }
    }

    public function lock(int $id): bool
    {
        return true;
    }

    public function unlock(int $id): void
    {
    }

    /**
     * 保存聊天信息到表中，注意，需要保存 is_completed 字段，避免下次查询时，会查到已经执行过的聊天任务
     */
    abstract public function save(ChatTask $task): bool;
}
