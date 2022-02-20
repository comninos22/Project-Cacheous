<?php
class EntityKey extends AbstractEntity implements IKey
{
    function __construct($keys)
    {
        parent::__construct($keys);
    }
    function extractSqlKey()
    {
        $s = '';
        foreach ($this->getParams() as $name => $value) {
            $s .= " $name=" . Utils::decorateValue($value) . " AND ";
        }
        return  trim($s, "AND ");
    }
    function extractRedisKey()
    {
        $s = ":{";
        foreach ($this->getParams() as $name => $value) {
            $s .= "$name|$value:";
        }
        return trim($s, ":") . "}";
    }
}
