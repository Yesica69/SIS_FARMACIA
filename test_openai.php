<?php
$apiKey = 'sk-proj-oVa62Sgxr9ZGhL3d8kTXjno6GErd4S_HPOVU7VxHAkpeKX8EVLEPa3wLfYD3BV1rM
ehKgNFKu6T3BlbkFJ6l2ZyooKR630YN8B2bNjyuu1bpl12r5rtWgAQIuNLUCY5IWy5MTSNnkQBqZ16YercseZIF6_oA'; // Cambia aquí por tu clave API de OpenAI, sin espacios ni comillas extras

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/chat/completions');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);

$data = [
    'model' => 'gpt-4',
    'messages' => [
        ['role' => 'system', 'content' => 'Eres un asistente IA.'],
        ['role' => 'user', 'content' => 'Hola, prueba de conexión']
    ],
    'temperature' => 0.7
];

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Bearer $apiKey"
]);

$result = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    echo $result;
}

curl_close($ch);
