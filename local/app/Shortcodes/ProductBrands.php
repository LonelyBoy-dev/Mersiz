<?php

namespace App\Shortcodes;

use App\Brand;
use Vedmant\LaravelShortcodes\Shortcode;

class ProductBrands extends Shortcode
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

        $brands = Brand::where('status', 'Show')->take($count)->get();
        return $this->view('shortcodes.brands', compact('atts', 'shared', 'content','brands'));
    }


}
