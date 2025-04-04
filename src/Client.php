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

use GuzzleHttp;
use Hyperf\Codec\Json;

class Client
{
    public Conversation $conversation;

    public Chat $chat;

    public function __construct(protected TokenInterface $token)
    {
        $this->conversation = new Conversation($this);
        $this->chat = new Chat($this);
    }

    public function client()
    {
        return new GuzzleHttp\Client([
            'base_uri' => 'https://api.coze.cn',
        ]);
    }

    public function request(string $method, string $url, array $options = []): array
    {
        $options['headers']['Authorization'] = sprintf('Bearer %s', $this->token->getToken());

        $response = $this->client()->request($method, $url, $options);

        $result = Json::decode((string) $response->getBody());

        if ($result['code'] !== 0) {
            throw (new RequestException($result['msg'], $result['code']))->withRawData($result);
        }

        return $result;
    }
}
