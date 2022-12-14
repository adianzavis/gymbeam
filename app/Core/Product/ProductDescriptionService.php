<?php

namespace App\Core\Product;

use App\Core\TextSentiment\DescriptionSentimentService;

class ProductDescriptionService {
    private MostUsedWordBusiness $business;
    private ProductList $productList;
    private DescriptionSentimentService $descriptionSentimentService;

    public function __construct() {
        $this->business = new MostUsedWordBusiness();
        $this->productList = new ProductList();
        $this->descriptionSentimentService = new DescriptionSentimentService();
    }

    public function findMostUsedWord(): array {
        $products = $this->productList->get();
        $products = $this->removeRedundantDescriptionCharactersForMany($products);

        $allWords = [];
        foreach ($products as $product) {
            $words = explode(' ', $product->getDescription());
            $allWords = $this->business->wordsCountToArray($words, $allWords);
        }

        asort($allWords);
        return array_slice($allWords, -10, 10, true);
    }

    public function removeRedundantDescriptionCharactersForMany(array $products): array {
        return array_map(fn(Product $product) => $this->removeRedundantDescriptionCharacters($product), $products);
    }

    public function removeRedundantDescriptionCharacters(Product $product): Product {
        return $product->setDescription($this->business->formatDescriptionForAnalytics($product->getDescription()));
    }

    public function getBestDescriptionSentiment(): array {
        $products = $this->productList->get();

        $ratedProducts = array_reduce($products, function(array $rp, Product $product): array {
            try {
                $rating = $this->descriptionSentimentService->getTextRating($product->getDescription());
                $rp[$product->getName()] = $rating;
            } catch(\Throwable $e) {
                echo $e->getMessage();
                //Log or whatever;
            }

            return $rp;
        }, []);

        asort($ratedProducts);
        return array_slice($ratedProducts, -10, 10, true);
    }
}