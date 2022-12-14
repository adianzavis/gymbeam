<?php

namespace App\Core\TextSentiment;

use App\Core\TextSentiment\Drivers\FakeSentiment;
use App\Core\TextSentiment\Drivers\Text2Data;
use App\Core\TextSentiment\Drivers\TextSentimentDriverInterface;

class TextSentimentAdapter {
    /*
     * You can switch the sentiment api to text2data for example, by changing PRIMARY_DRIVER constant
     */
    private TextSentimentDriverInterface $driver;

    private const TEXT_2_DATA = 'text2data';
    private const FAKE_SENTIMENT = 'fake_sentiment';

    private array $drivers = [
        self::TEXT_2_DATA => Text2Data::class,
        self::FAKE_SENTIMENT => FakeSentiment::class,
    ];

    private const PRIMARY_DRIVER = self::TEXT_2_DATA;
    private const FALLBACK_DRIVER = self::FAKE_SENTIMENT;

    public function __construct(string $text) {
        try {
            $this->driver = new $this->drivers[self::PRIMARY_DRIVER]($text);
        } catch (\Throwable $e) {
            try {
                echo "Fallback driver used\r\n";
                $this->driver = new $this->drivers[self::FALLBACK_DRIVER]($text);
            } catch (\Throwable $e) {
                throw new \Exception('sentiment drivers are not available');
            }
        }
    }

    public function getRating(): float {
        return $this->driver->getRating();
    }

    public function getStringRating(): string {
        return $this->driver->getStringRating();
    }
}