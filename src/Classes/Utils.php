<?php
class Utils
{

    static function decorateValue($value)
    {
        return (gettype($value) == "string" ? "'$value'" : $value);
    }
   
}
