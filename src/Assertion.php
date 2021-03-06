<?php

/*
 * This file is part of Respect/Assertion.
 *
 * (c) Henrique Moody <henriquemoody@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE file
 * that was distributed with this source code.
 */

declare(strict_types=1);

namespace Respect\Assertion;

use Respect\Validation\Validatable;
use Throwable;

interface Assertion
{
    public function getRule(): Validatable;

    /**
     * @return Throwable|string|null
     */
    public function getDescription();

    /**
     * Execute the assertion
     *
     * @param mixed $input
     *
     * @throws Throwable
     */
    public function assert($input): void;
}
