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
}
