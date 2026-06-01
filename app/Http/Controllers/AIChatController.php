<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIChatController extends Controller
{
    public function askAI(Request $request)
    {
        $userMessage = $request->input('message');

        // Validate input
        if (!$userMessage) {
            return response()->json(['reply' => 'Meherbani se pegham likhein.'], 400);
        }

        // OpenAI API request
        $response = Http::withToken(env('OPENAI_API_KEY'))->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Tum ek tajurba kaar animal doctor ho. Roman Urdu mein baat karo. Livestock (cow, buffalo, goat, sheep) ke ilaj mein madad karo.'
                ],
                [
                    'role' => 'user',
                    'content' => $userMessage
                ],
            ],
            'temperature' => 0.7,
        ]);

        // Response handling
        if ($response->successful()) {
            return response()->json([
                'reply' => $response['choices'][0]['message']['content']
            ]);
        } else {
            return response()->json([
                'reply' => 'Kuch masla ho gaya hai. Doctor se rabta nahi ho saka.'
            ], 500);
        }
    }
}
