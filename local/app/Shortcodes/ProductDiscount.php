<?php

namespace App\Shortcodes;

use App\Product;
use Vedmant\LaravelShortcodes\Shortcode;

class ProductDiscount extends Shortcode
{
    public $description = 'Shortcode description';

    public $attributes = [
        'count'  => [
            'default'     => '0',
        ],
    ];

    public function render($content)
    {
        $atts = $this->atts();
        $shared = $this->shared();

        $count = $atts['count'];

        $products_discount = Product::where('status', 'PUBLISHED')->where('discount', '!=', '0')->take($count)->get();
        return $this->view('shortcodes.products_discount', compact('atts', 'shared', 'content','products_discount'));
    }


    
}
