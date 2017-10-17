<?php

use Nulltrain\Rope\Rope;

if ( ! function_exists('rope')) {
    /**
     * Create a rope from the given value.
     *
     * @param  mixed $value
     *
     * @return Rope
     */
    function rope($value = null)
    {
        return new Rope($value);
    }
}