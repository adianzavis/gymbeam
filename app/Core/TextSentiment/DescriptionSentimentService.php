<?php

namespace App\Core\TextSentiment;

class DescriptionSentimentService {
    public function getTextRating(string $text): float {
        $textSentimentAdapter = new TextSentimentAdapter($text);
        return $textSentimentAdapter->getRating();
    }
}