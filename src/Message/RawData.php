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

abstract class RawData
{
    public ?array $rawData = null;

    public function withRawData(?array $rawData = null): static
    {
        $this->rawData = $rawData;
        return $this;
    }
}
