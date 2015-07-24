<?php


class Converter
{
    public static function megaByte($data)
    {
        $convert = round(($data/1024)/1024, 2);
        
        return $convert;
    }
}