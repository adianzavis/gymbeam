<?php

namespace App\Core\Product;

class ProductDescriptionService {
    private MostUsedWordBusiness $business;
    private ProductList $productList;

    public function __construct() {
        $this->business = new MostUsedWordBusiness();
        $this->productList = new ProductList();
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
}