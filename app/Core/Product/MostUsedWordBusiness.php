<?php

namespace App\Core\Product;

class MostUsedWordBusiness {
    public function wordsCountToArray(array $words, array $initWords = []): array {
        foreach ($words as $word) {
            if ($word === '') {
                continue;
            }

            $word = mb_strtolower($word);

            if (isset($initWords[$word])) {
                $initWords[$word] += 1;
            } else {
                $initWords[$word] = 1;
            }
        }

        return $initWords;
    }

    public function formatDescriptionForAnalytics(string $description): string {
        $description = $this->removeCommonWords($description);
        $description = $this->removeMarks($description);
        $description = $this->removeNumbers($description);
        $description = $this->removeOneCharacterWords($description);
        return $this->removeWhiteSpaces($description);
    }

    private function removeCommonWords(string $description): string {
        $words = ['a', 'and', 'but', 'or', 'it', 'is', 'for', 'one', 'in', 'the', 'of', 'up', 'to', 'your', 'with', 'which', 'that', 'you', 'are', 'as', 'an', 'can', 'has', 'also', 'made', 'will', 'from', 'its', 'not', 'on', 'this', 'any'];
        $pattern = '/\b(?:' . join('|', $words) . ')\b/i';
        return preg_replace($pattern, '', $description);
    }

    private function removeMarks(string $description): string {
        return str_replace(['.', '!', '"', '?', '-', ':', ';', ',', '+'], ' ', $description);
    }

    private function removeNumbers(string $description): string {
        return preg_replace('/[0-9]+/', ' ', $description);
    }

    private function removeOneCharacterWords(string $description): string {
        return preg_replace('/(^|\s+)(\S(\s+|$))+/', ' ', $description);
    }

    private function removeWhiteSpaces(string $description): string {
        return preg_replace('/\s\s+/', ' ', $description);
    }
}