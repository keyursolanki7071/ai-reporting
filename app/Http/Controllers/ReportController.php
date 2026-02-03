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
        return Inertia::render('Chat', [
            'response' => null,
        ]);
    }

    public function chat(Request $request): Response
    {
        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $agent = ReportAgent::make();

        $response = $agent->chat(
            new UserMessage($request->input('message'))
        );

        $content = $response->getContent();
        $html = app(MarkdownRenderer::class)->toHtml($content);

        return Inertia::render('Chat', [
            'response' => $html,
            'original_message' => $request->input('message'),
        ]);
    }
}
