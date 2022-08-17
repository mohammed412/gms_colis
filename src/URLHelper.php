<?php

namespace App;

class URLHelper{

    public static function withParam(string $param, string $value) : string{
        return http_build_query(array_merge($_GET, [$param => $value]));
    } 
}

?>