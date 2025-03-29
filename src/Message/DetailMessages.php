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

class DetailMessages extends RawData implements JsonSerializable, JsonDeSerializable
{
    /**
     * @param DetailMessage[] $messages
     */
    public function __construct(public array $messages)
    {
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        $messages = [];
        foreach ($data as $message) {
            $messages[] = DetailMessage::jsonDeserialize($message);
        }
        return new static($messages);
    }

    public function jsonSerialize(): mixed
    {
        return $this->messages;
    }
}
