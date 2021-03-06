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

namespace Respect\Assertion\Assertor;

use BadMethodCallException;
use Countable;
use Respect\Assertion\Assertion;
use Respect\Assertion\Assertor;
use Respect\Validation\Exceptions\ValidationException;

use function count;
use function is_array;
use function is_string;
use function mb_strlen;
use function Respect\Stringifier\stringify;

final class LengthAssertor implements Assertor
{
    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'length';
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Assertion $assertion, $input): void
    {
        try {
            $assertion->assert($this->getLength($input));
        } catch (ValidationException $exception) {
            throw $this->getCustomizedException($input, $exception);
        }
    }

    /**
     * @param mixed $input
     */
    private function getLength($input): int
    {
        if (is_string($input)) {
            return mb_strlen($input);
        }

        if (is_array($input)) {
            return count($input);
        }

        if ($input instanceof Countable) {
            return $input->count();
        }

        throw new BadMethodCallException('Assertion with "length" prefix must be countable or string');
    }

    /**
     * @param mixed $asserted
     */
    private function getCustomizedException($asserted, ValidationException $exception): ValidationException
    {
        if ($exception->hasCustomTemplate()) {
            return $exception;
        }

        $params = $exception->getParams();
        $params['name'] = $params['input'] . ', the length of ' . stringify($asserted) . ',';
        $exception->updateParams($params);

        return $exception;
    }
}
