<?php

declare(strict_types=1);

namespace Tests\App;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

/**
 * @internal
 */
final class DetectLangTest extends TestCase
{
    /**
     * @psalm-return array<string,string>
     */
    protected function server(): array
    {
        return [
            'HTTP_HOST' => 'localhost',
            'HTTPS' => 'on',
            'REQUEST_URI' => '/docs?page=7#chapter=2',
            'REQUEST_METHOD' => 'POST',
            'CONTENT_TYPE' => 'text/plain',
            'CONTENT_LENGTH' => '10',
        ];
    }

    public function testDefault(): void
    {
        assertEquals('ru', detectLang('ru', createServerRequestFromGlobals($this->server())));
    }

    public function testQuery(): void
    {
        $request = createServerRequestFromGlobals($this->server(), query: ['lang' => 'de']);
        assertEquals('de', detectLang('ru', $request));
    }

    public function testCookie(): void
    {
        $request = createServerRequestFromGlobals($this->server(), cookie: ['lang' => 'jp']);
        assertEquals('jp', detectLang('ru', $request));
    }

    public function testHeaders(): void
    {
        $request = createServerRequestFromGlobals(['REQUEST_METHOD' => 'POST', 'HTTP_ACCEPT-LANGUAGE' => 'fr']);
        assertEquals('fr', detectLang('ru', $request));
    }
}
