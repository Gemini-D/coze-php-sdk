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
use Coze\ChatTask;
use Coze\ChatTaskRunner;
use Coze\Client;
use Coze\Message\DetailMessages;
use Coze\Message\RetrieveMessage;
use Coze\Token;

require __DIR__ . '/vendor/autoload.php';

$token = new Token(file_get_contents('token.txt'));
$botId = (string) file_get_contents('bot_id.txt');

$client = new Client($token);

$res = $client->chat->send($botId, '123', [
    [
        'content' => '请给我一份上海宝山的房源数据',
        'content_type' => 'text',
        'role' => 'user',
        'type' => 'question',
    ],
]);

$task1 = ChatTask::fromRetrieveMessage($res, 1);

$res = $client->chat->send($botId, '1234', [
    [
        'content' => '请给我一份上海嘉定的房源数据',
        'content_type' => 'text',
        'role' => 'user',
        'type' => 'question',
    ],
]);

$task2 = ChatTask::fromRetrieveMessage($res, 2);

$runner = new class($client, [$task1, $task2]) extends ChatTaskRunner {
    public function __construct(Client $client, public array $tasks)
    {
        parent::__construct($client);
    }

    public function scroll(int $id): array
    {
        if ($id === 0) {
            return $this->tasks;
        }

        return [];
    }

    public function execute(ChatTask $task): void
    {
        var_dump('执行 ' . $task->chatId);
        parent::execute($task);
    }

    public function save(ChatTask $task, RetrieveMessage $retrieved, DetailMessages $messages): bool
    {
        var_dump('执行完毕 ' . $task->chatId, $task->isCompleted);
        var_dump($messages->withRawData());
        return true;
    }
};

while (true) {
    sleep(1);

    $runner->run();

    if ($task1->isCompleted && $task2->isCompleted) {
        break;
    }
}
