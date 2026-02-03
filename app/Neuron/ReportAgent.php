<?php

declare(strict_types=1);

namespace App\Neuron;

use App\Services\SchemaFetcher;
use App\Services\SchemaFormatter;
use NeuronAI\Agent;
use NeuronAI\Providers\AIProviderInterface;
use NeuronAI\Providers\Gemini\Gemini;
use NeuronAI\SystemPrompt;
use NeuronAI\Tools\ToolInterface;
use NeuronAI\Tools\Toolkits\ToolkitInterface;

class ReportAgent extends Agent
{
    protected function provider(): AIProviderInterface
    {
        return new Gemini(
            key: config('services.gemini.key', env('GEMINI_API_KEY')),
            model: 'gemini-2.5-flash-preview-09-2025',
        );
    }

    public function instructions(): string
    {
        $schema = app(SchemaFormatter::class)
            ->format(app(SchemaFetcher::class)->fetch());

        $prompt = "
            $schema

            You are a MySQL reporting AI agent.

            Rules:
            - You must call the tool 'run_sql' to fetch data
            - Only SELECT queries are allowed
            - Use only the provided schema
            - Do not invent any columns not provided in schema
            - If a request is impossible, say so clearly
            - Always show dates in human friendly format like 06 May, 2025
        ";

        return (string) new SystemPrompt(
            background: [$prompt],
        );
    }

    /**
     * @return ToolInterface[]|ToolkitInterface[]
     */
    protected function tools(): array
    {
        return [
            RunSqlTool::make(),
        ];
    }
}
