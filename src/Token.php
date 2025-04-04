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

class Token implements TokenInterface
{
    public function __construct(public string $token)
    {
    }

    public function getToken(mixed $key = null): string
    {
        return $this->token;
    }
}
