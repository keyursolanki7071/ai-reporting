<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SchemaFetcher
{
    public function fetch(string $connection = self::CONNECTION): array
    {
        // return Cache::remember('db_schema_' . $connection, 3600, function () use ($connection) {
            return DB::connection($connection)->select("
                SELECT table_name, column_name, data_type
                FROM information_schema.columns
                WHERE table_schema = DATABASE()
                ORDER BY table_name, ordinal_position
            ");
        // });
    }
}
