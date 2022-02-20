<?php
class EntityBody extends AbstractEntity implements IBody
{
    function __construct($keys)
    {
        parent::__construct($keys);
    }
    function getInsertKeys()
    {
        return array_keys($this->getParams());
    }
    function getInsertValues()
    {
        return array_map(function ($key, $value) {
            return Utils::decorateValue($value);
        }, $this->getParams());
    }
    function getUpdatePairs()
    {
        return implode(",", array_map(function ($key, $value) {
            return "$key=" . Utils::decorateValue($value);
        }, $this->getParams()));
    }
}
