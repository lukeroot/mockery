<?php

declare(strict_types=1);

/**
 * Mockery (https://docs.mockery.io/)
 *
 * @copyright https://github.com/mockery/mockery/blob/HEAD/COPYRIGHT.md
 * @license https://github.com/mockery/mockery/blob/HEAD/LICENSE BSD 3-Clause License
 * @link https://github.com/mockery/mockery for the canonical source repository
 */

use Mockery\LegacyMockInterface;
use Mockery\Matcher\AndAnyOtherArgs;
use Mockery\Matcher\AnyArgs;
use Mockery\MockInterface;

if (! \function_exists('mock')) {
    /**
     * @template TMock
     *
     * @param TMock ...$args
     *
     * @return (LegacyMockInterface&TMock)|(MockInterface&TMock)
     */
    function mock(...$args)
    {
        return Mockery::mock(...$args);
    }
}

if (! \function_exists('spy')) {
    /**
     * @template TSpy
     *
     * @param TSpy ...$args
     *
     * @return (LegacyMockInterface&TSpy)|(MockInterface&TSpy)
     */
    function spy(...$args)
    {
        return Mockery::spy(...$args);
    }
}

if (! \function_exists('namedMock')) {
    /**
     * @template TNamedMock
     *
     * @param TNamedMock ...$args
     *
     * @return (LegacyMockInterface&TNamedMock)|(MockInterface&TNamedMock)
     */
    function namedMock(...$args)
    {
        return Mockery::namedMock(...$args);
    }
}

if (! \function_exists('anyArgs')) {
    function anyArgs(): AnyArgs
    {
        return new AnyArgs();
    }
}

if (! \function_exists('andAnyOtherArgs')) {
    function andAnyOtherArgs(): AndAnyOtherArgs
    {
        return new AndAnyOtherArgs();
    }
}

if (! \function_exists('andAnyOthers')) {
    function andAnyOthers(): AndAnyOtherArgs
    {
        return new AndAnyOtherArgs();
    }
}
