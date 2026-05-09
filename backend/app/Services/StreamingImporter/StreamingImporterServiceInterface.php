<?php

namespace App\Services\StreamingImporter;

interface StreamingImporterServiceInterface
{
    public function getAccessToken(): string;
    public function import(string $isrc): ?array;
}
