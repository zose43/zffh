<?php

declare(strict_types=1);

namespace DetectLang;

use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

/**
 * @internal
 * @psalm-suppress all
 */
final class DetectLangTest extends TestCase
{
    private LangRequestContract $langRequest;

    protected function setUp(): void
    {
        parent::setUp();
        $this->langRequest = $this->createMock(LangRequestContract::class);
    }

    public function testDefault(): void
    {
        $this->langRequest->expects(self::once())
            ->method('getQuery')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::once())
            ->method('getCookie')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::never())
            ->method('getHeader')
            ->with('Accept-Language')
            ->willReturn([]);
        $this->langRequest->expects(self::once())
            ->method('hasHeader')
            ->with('Accept-Language')
            ->willReturn(false);

        assertEquals('ru', detectLang('ru', $this->langRequest));
    }

    public function testQuery(): void
    {
        $this->langRequest->expects(self::exactly(2))
            ->method('getQuery')
            ->with('lang')
            ->willReturn('de');
        $this->langRequest->expects(self::never())
            ->method('getCookie')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::never())
            ->method('getHeader')
            ->with('Accept-Language')
            ->willReturn([]);
        $this->langRequest->expects(self::never())
            ->method('hasHeader')
            ->with('Accept-Language')
            ->willReturn(false);

        assertEquals('de', detectLang('ru', $this->langRequest));
    }

    public function testCookie(): void
    {
        $this->langRequest->expects(self::once())
            ->method('getQuery')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::exactly(2))
            ->method('getCookie')
            ->with('lang')
            ->willReturn('jp');
        $this->langRequest->expects(self::never())
            ->method('getHeader')
            ->with('Accept-Language')
            ->willReturn([]);
        $this->langRequest->expects(self::never())
            ->method('hasHeader')
            ->with('Accept-Language')
            ->willReturn(false);

        assertEquals('jp', detectLang('ru', $this->langRequest));
    }

    public function testHeaders(): void
    {
        $this->langRequest->expects(self::once())
            ->method('getQuery')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::once())
            ->method('getCookie')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::once())
            ->method('getHeader')
            ->with('Accept-Language')
            ->willReturn(['fr']);
        $this->langRequest->expects(self::once())
            ->method('hasHeader')
            ->with('Accept-Language')
            ->willReturn(true);

        assertEquals('fr', detectLang('ru', $this->langRequest));
    }

    public function testMultipleHeader(): void
    {
        $this->langRequest->expects(self::once())
            ->method('getQuery')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::once())
            ->method('getCookie')
            ->with('lang')
            ->willReturn('');
        $this->langRequest->expects(self::once())
            ->method('getHeader')
            ->with('Accept-Language')
            ->willReturn(['sp', 'fr', 'en']);
        $this->langRequest->expects(self::once())
            ->method('hasHeader')
            ->with('Accept-Language')
            ->willReturn(true);
        assertEquals('sp', detectLang('ru', $this->langRequest));
    }
}
