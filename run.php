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

$client->conversation->create();
