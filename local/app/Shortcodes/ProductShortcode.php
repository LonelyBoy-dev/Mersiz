<?php

namespace App\Shortcodes;

use App\Product;
use Vedmant\LaravelShortcodes\Shortcode;

class ProductShortcode extends Shortcode
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

        $sale_product = Product::where('status', 'PUBLISHED')->orderby('sale', 'desc')->take($count)->get();
        return $this->view('shortcodes.product', compact('atts', 'shared', 'content','sale_product'));
    }

    
}
