<?php

if (! function_exists('strChange')) {
    function strChange($getStr) {
        $str = trim(ucwords(strtolower($getStr)));
        return $str;
    }
}