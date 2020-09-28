<?php


namespace App;


class Helper
{
    public static function echoPrint(...$arg){
        if (count($arg)==1)
            $arg = $arg[0];
        echo print_r($arg,true)."\n";
    }
}