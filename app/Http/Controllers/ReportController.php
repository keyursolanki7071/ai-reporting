<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Neuron\ReportAgent;
use App\Services\MarkdownRenderer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use NeuronAI\Chat\Messages\UserMessage;

class ReportController extends Controller
{
    public function index(): Response
    {
        $configs = \App\Models\DatabaseConfig::where('is_active', true)->get();
        return Inertia::render('Chat', [
            'response' => null,
            'configs' => $configs,
        ]);
    }

    public function chat(Request $request): Response
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
            'config_id' => ['required', 'exists:database_configs,id'],
        ]);

        $config = \App\Models\DatabaseConfig::find($request->input('config_id'));

        $connection = 'dynamic_chat_' . $config->id;
        config(["database.connections.$connection" => [
            'driver' => 'mysql',
            'host' => $config->host,
            'port' => $config->port,
            'database' => $config->database,
            'username' => $config->username,
            'password' => $config->password,
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'strict' => true,
            'engine' => null,
        ]]);

        $agent = new ReportAgent($connection);

        $response = $agent->chat(
            new UserMessage($request->input('message'))
        );

        $content = $response->getContent();
        $html = app(MarkdownRenderer::class)->toHtml($content);

        return Inertia::render('Chat', [
            'response' => $html,
            'configs' => \App\Models\DatabaseConfig::where('is_active', true)->get(),
            'selected_config_id' => (int) $request->input('config_id'),
            'original_message' => $request->input('message'),
        ]);
    }
}
