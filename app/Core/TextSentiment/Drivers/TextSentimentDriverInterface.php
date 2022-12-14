<?php

namespace App\Core\TextSentiment\Drivers;

interface TextSentimentDriverInterface {
    public function __construct(string $text);
    public function getText(): string;
    public function getRating(): float;
    public function getStringRating(): string;
}