<?php
use App\Models\TbFilas;

if ( ! function_exists('getAvaliableRedisDatabase') ){
    function getAvaliableRedisDatabase() {
        return (new TbFilas())->getAvaliableDatabase();
    }
}
