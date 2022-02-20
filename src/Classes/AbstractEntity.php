<?php
abstract class AbstractEntity
{
    private $params,  $keys;

    function __construct($keys)
    {
        $this->keys = $this->parseKeysAndTypes($keys);
    }
    function getParams()
    {
        return $this->params;
    }
    function setParams($params)
    {
        $this->params = [];
        array_map(function ($key, $value) {
            if (in_array($key, array_keys($this->keys))) {
                switch ($this->keys[$key]) {
                    case "s":
                        $value = "" + $value;
                    case "d":
                        $value = 1 * $value;
                }
                $this->params += [$key, $value];
            }
        }, $params);
        if (count($this->params) !== count($params)) {
            throw new Exception("Parameters mismatch");
        }
    }
    protected function checkEmpty()
    {
        foreach ($this->params as $key => $value) {
            if (empty($this->params[$key])) throw new Exception("Key is empty, props didn't match");
        }
    }
    function parseKeysAndTypes($keys)
    {
        $a = [];
        foreach ($keys as $key) {
            $a[] = [explode(":", $key)[0] => explode(":", $key)[1]];
        }
        return $a;
    }
}
