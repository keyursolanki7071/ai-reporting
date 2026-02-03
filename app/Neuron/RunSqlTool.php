<?php

declare(strict_types=1);

namespace App\Neuron;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolProperty;

class RunSqlTool extends Tool
{
    public function __construct()
    {
        parent::__construct(
            'run_sql',
            'Execute a safe, read-only SQL SELECT query',
        );
    }

    protected function properties(): array
    {
        return [
            new ToolProperty(
                name: 'sql',
                type: PropertyType::STRING,
                description: 'SQL query to run',
                required: true,
            ),
        ];
    }

    public function __invoke(string $sql): array
    {
        Log::info('Executing SQL Tool: '.$sql);

        if (! Str::of($sql)->trim()->upper()->startsWith('SELECT')) {
            throw new InvalidArgumentException('Only SELECT queries are allowed for security reasons.');
        }

        return DB::connection('report')->select($sql);
    }
}
