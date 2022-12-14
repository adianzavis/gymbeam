<?php

namespace App\Core\TextSentiment\Drivers;

use GuzzleHttp\Client;

class Text2Data implements TextSentimentDriverInterface {
    /*
     * This api has just 64 free calls per day and 10000 calls per 30 days limit.
     */
    private const API_URL = 'http://api.text2data.com/v3/analyze';
    private const API_KEY = '947FCDC4-6FF5-4FC5-8035-A2EEBA1F948D';
    private const API_SECRET = 'neviemake';

    private string $text;
    private float $rating;
    private string $ratingString;

    public function __construct(string $text) {
        $this->text = $text;

        $client = new Client();

        $options = $this->buildOptions($text);
        $response = $client->post(self::API_URL, $options);
        $data = json_decode($response->getBody()->getContents());

        if (!isset($data->DocSentimentValue) || !isset($data->DocSentimentResultString)) {
            throw new \Exception('Wrong server response');
        }

        $this->rating = $data->DocSentimentValue;
        $this->ratingString = $data->DocSentimentResultString;
    }

    public function getText(): string {
        return $this->text;
    }

    public function getRating(): float {
        return $this->rating;
    }

    public function getStringRating(): string {
        return $this->ratingString;
    }

    private function buildOptions(string $text): array {
        return [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ],
            'body' => json_encode([
                "DocumentText" => $text,
                "IsTwitterContent" => false,
                "PrivateKey" => self::API_KEY,
                "Secret" => self::API_SECRET,
                "UserCategoryModelName" => "",
                "DocumentLanguage" => "en",
                "SerializeFormat" => 1,
                "RequestIdentifier" => "",
            ])
        ];
    }
}