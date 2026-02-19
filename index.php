<?php
header("Content-Type: application/json");

$input = json_decode(file_get_contents("php://input"), true);
$message = $input["message"] ?? "";

$apiKey = getenv("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");

$data = [
  "model" => "gpt-4o-mini",
  "messages" => [
    ["role" => "system", "content" => "You are a helpful assistant."],
    ["role" => "user", "content" => $message]
  ]
];

$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_POST => true,
  CURLOPT_HTTPHEADER => [
    "Authorization: Bearer $apiKey",
    "Content-Type: application/json"
  ],
  CURLOPT_POSTFIELDS => json_encode($data)
]);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);
echo json_encode([
  "reply" => $result["choices"][0]["message"]["content"] ?? "Error"
]);
