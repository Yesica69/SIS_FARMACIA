use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

Route::post('/ask-openai', function (Request $request) {
    $prompt = $request->input('message');
    
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
        'Content-Type' => 'application/json',
    ])->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-3.5-turbo',
        'messages' => [
            [
                'role' => 'system',
                'content' => 'Eres un farmacéutico especializado. Responde en formato markdown con: 1) 💊 Medicamentos (dosis) 2) ⚠️ Contraindicaciones 3) 🌿 Alternativas naturales. Sé conciso.'
            ],
            [
                'role' => 'user',
                'content' => $prompt
            ]
        ],
        'temperature' => 0.3,
        'max_tokens' => 200
    ]);

    return $response->json();
});