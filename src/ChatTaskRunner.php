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
     * 定时处理已经调的对话任务
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

                    $this->execute($task);
                } finally {
                    $this->unlock($id);
                }
            }
        }
    }

    /**
     * 执行单个对话任务，可以在定时任务之外，当提交一次对话任务后，直接在协程或者异步队列中延时执行.
     * 具体延时时间，按照自己的业务场景而定.
     */
    public function execute(ChatTask $task): void
    {
        $retrieved = $this->client->chat->retrieve($task->chatId, $task->conversationId);

        $task->isCompleted = $retrieved->isCompleted();

        $this->save($task);
    }

    public function lock(int $id): bool
    {
        return true;
    }

    public function unlock(int $id): void
    {
    }

    /**
     * 保存对话信息到表中，注意，需要保存 is_completed 字段，避免下次查询时，会查到已经执行过的对话任务
     */
    abstract public function save(ChatTask $task): bool;
}
