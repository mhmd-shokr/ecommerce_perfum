<?php
namespace App\Servicies;

use GeminiAPI\Client;
use GeminiAPI\Resources\Parts\TextPart;

class AitranslationService{
    public $client;
    public function __construct(){
        $this->client=new Client(
            config('services.gemini.api_key')
        );
    }

    public function translate($text, $language)
    {
        $json = json_encode($text, JSON_UNESCAPED_UNICODE);

        $prompt = "
        Translate the following text to {$language}.

        Rules:
        - Return ONLY JSON.
        - No markdown.
        - No ```json.
        - The response must start with { and end with }.
        - Keep keys exactly the same.
        - Keep placeholders like :name.

        
        Json:
        {$json}
        ";

        $result = $this->client
            ->generativeModel('gemini-2.5-flash')
            ->generateContent(
                new TextPart($prompt)
            );
            

            $response = $result->text();

            $response = preg_replace('/```json|```/', '', $response);
            
            $response = trim($response);
            
            
            // Extract JSON only
            preg_match('/\{.*\}/s', $response, $matches);
            
            if (!empty($matches[0])) {
                $response = $matches[0];
            }
            
            
            $data = json_decode($response, true);
            
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception(
                    json_last_error_msg()
                );
            }
            
            
            return $data;
    }
}