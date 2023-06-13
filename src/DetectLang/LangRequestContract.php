<?php

declare(strict_types=1);

namespace DetectLang;

interface LangRequestContract
{
    public function getQuery(string $value): string;

    /** @psalm-return   array<string,string[]> */
    public function getHeaders(): array;

    /** @psalm-return string[] */
    public function getHeader(string $header): array;

    public function getCookie(string $value): string;

    public function hasHeader(string $header): bool;
}
