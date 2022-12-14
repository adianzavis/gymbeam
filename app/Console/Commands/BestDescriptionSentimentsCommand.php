<?php

namespace App\Console\Commands;

use App\Core\Product\ProductDescriptionService;
use App\Core\Product\ProductList;

class BestDescriptionSentimentsCommand implements CommandInterface {
    /*
     * This command returns associative array of most used words in the description database.
     * Key is the word and its value means how many times does it appear among descriptions.
     * Words mentioned in product name are not included.
     *
     * To run this command call: php app/console/run.php most-used-word
     */
    public function run() {
        $service = new ProductDescriptionService();
        var_dump($service->getBestDescriptionSentiment());
        die();
    }
}
