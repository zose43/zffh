<?php

declare(strict_types=1);

namespace Tests\App;

use App\Example;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
final class ExampleTest extends TestCase
{
    /**
     * @covers \App\Example
     */
    public function testExample(): void
    {
        $result = (new Example())->example();
        self::assertEquals(43, $result);
    }
}
