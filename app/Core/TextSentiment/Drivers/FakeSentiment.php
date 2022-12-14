<?php

namespace App\Core\TextSentiment\Drivers;

class FakeSentiment implements TextSentimentDriverInterface {
    private string $text;
    private float $rating;

    public function __construct(string $text) {
        $this->text = $text;
        $this->rating = rand(-1000, 1000)/1000;
    }

    public function getText(): string {
        return $this->text;
    }

    public function getRating(): float {
        return $this->rating;
    }

    public function getStringRating(): string {
        return 'average';
    }
}