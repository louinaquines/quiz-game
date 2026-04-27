<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenRouterService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://openrouter.ai/api/v1/chat/completions';
    protected string $model;

    public function __construct()
    {
        $this->apiKey = config('services.openrouter.key', env('OPENROUTER_API_KEY', ''));
        $this->model = config('services.openrouter.model', env('OPENROUTER_MODEL', 'anthropic/claude-3-haiku-20240307'));
    }

    public function generateQuestions(string $topic, int $count = 10): array
    {
        $prompt = <<<PROMPT
Generate {$count} multiple choice quiz questions about "{$topic}".
Return ONLY a JSON array with no markdown formatting, no explanation, and no code fences.
Each object must have exactly these keys:
- "text" (string): the question text.
- "choices" (array of exactly 4 strings): the possible answers.
- "correct_index" (integer 0-3): index of the correct answer in choices.

Example:
[
  {"text":"What is 2+2?","choices":["1","2","3","4"],"correct_index":3}
]
PROMPT;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
            'HTTP-Referer' => config('app.url', 'http://localhost'),
        ])->post($this->baseUrl, [
            'model' => $this->model,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);

        if (!$response->successful()) {
            Log::error('OpenRouter API error', ['status' => $response->status(), 'body' => $response->body()]);
            throw new \RuntimeException('Failed to generate questions from AI.');
        }

        $json = $response->json();
        $content = $json['choices'][0]['message']['content'] ?? null;

        if (!$content) {
            throw new \RuntimeException('Empty response from AI.');
        }

        // Strip markdown fences if present
        $content = preg_replace('/^```json\s*/i', '', $content);
        $content = preg_replace('/```\s*$/', '', $content);

        $questions = json_decode(trim($content), true);

        if (!is_array($questions)) {
            throw new \RuntimeException('Invalid JSON from AI.');
        }

        return $questions;
    }
}
