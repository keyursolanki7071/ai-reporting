<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class SchemaFetcher
{
    const ALLOWED_TABLES = ['coupons', 'orders', 'users', 'order_items', 'products', 'warehouses', 'payment_schedules'];

    const CONNECTION = 'report';

    public function fetch(): array
    {
        // return Cache::remember('db_schema', 3600, function () {
            return DB::connection(self::CONNECTION)->select("
                SELECT table_name, column_name, data_type
                FROM information_schema.columns
                WHERE table_schema = DATABASE()
                AND table_name IN ('".implode("','", self::ALLOWED_TABLES)."')
                ORDER BY table_name, ordinal_position
            ");
        // });
    }
}
