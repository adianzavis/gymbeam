<?php

namespace App\Core\Product;

class ProductList {
    private const SOURCE_FILE_PATH = __DIR__.'/../../../src/product_list_gb.csv';

    private array $products = [];

    public function __construct() {
        $this->products = $this->loadProductsFromCsv();
    }

    public function get(): array {
        return $this->products;
    }

    private function loadProductsFromCsv(): array {
        $raw = str_getcsv(file_get_contents(self::SOURCE_FILE_PATH));
        $products = [];
        for ($i = 0; $i <= count($raw); $i+=2) {
            //Avoid possible php warning
            if (!isset($raw[$i+1])) {
                continue;
            }

            //Remove redundant spaces, new lines, html tags...
            $name = preg_replace( "/\r|\n/", "", $raw[$i]);
            $description = preg_replace( "/\r|\n/", "", strip_tags($raw[$i+1]));

            if (empty($name) || empty($description))
                continue;

            $products[] = (new Product())
                ->setName($name)
                ->setDescription($description);
        }

        return $products;
    }
}