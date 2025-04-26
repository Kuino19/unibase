<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIStudyAssistantController extends Controller
{
    public function summarize(Request $request)
    {
        // Validate the request
        $request->validate([
            'text' => 'required|string|max:8000',
        ]);

        try {
            // Call OpenAI API for summarization
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful study assistant. Summarize the following text in clear, concise points:'
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->text
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500
            ]);

            return response()->json([
                'summary' => $response->json()['choices'][0]['message']['content']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate summary',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function generateQuestions(Request $request)
    {
        // Validate the request
        $request->validate([
            'topic' => 'required|string|max:1000',
            'difficulty' => 'required|in:easy,medium,hard',
            'count' => 'required|integer|min:1|max:10'
        ]);

        try {
            // Call OpenAI API for question generation
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are an expert tutor. Generate {$request->count} {$request->difficulty} practice questions about: {$request->topic}. Include answers and explanations."
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 1000
            ]);

            return response()->json([
                'questions' => $response->json()['choices'][0]['message']['content']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to generate questions',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function explainConcept(Request $request)
    {
        // Validate the request
        $request->validate([
            'concept' => 'required|string|max:1000',
            'level' => 'required|in:beginner,intermediate,advanced'
        ]);

        try {
            // Call OpenAI API for concept explanation
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.openai.api_key'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => "You are a knowledgeable tutor. Explain the following concept at a {$request->level} level:"
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->concept
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 800
            ]);

            return response()->json([
                'explanation' => $response->json()['choices'][0]['message']['content']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to explain concept',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
