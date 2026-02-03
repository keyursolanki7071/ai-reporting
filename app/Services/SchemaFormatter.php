<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;

class SchemaFormatter
{
    public function format(array $schema): string
    {
        $grouped = collect($schema)->groupBy('table_name');
        $output = "Database schema:\n";

        foreach ($grouped as $table => $columns) {
            /** @var Collection $columns */
            $cols = $columns
                ->map(fn ($c) => "{$c->column_name} {$c->data_type}")
                ->implode(', ');

            $output .= "{$table}({$cols})\n";
        }

        return $output;
    }
}
