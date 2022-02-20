<?php
class Redis
{
    public $internal, $prefix;
    private static $instance;
    static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    private function __construct()
    {
        Predis\Autoloader::register();
        $this->internal = new Predis\Client(array(
            "scheme" => "tcp",
            "host" => "localhost",
            "port" => 6379,
            "password" => ""
        ));
    }

    function setPrefix($prefix)
    {
        $this->prefix = "dev_" . $prefix;
    }

    private function getKeyWithPrefix(Model $m)
    {
        return $this->prefix . $m->getKey()->extractRedisKey();
    }

    function get(Model $m)
    {
        $result = $this->internal->hgetall($this->getKeyWithPrefix($m));
        if (empty($result)) throw new Exception("Item not found in cache...");
        return $result;
    }
    function getAll(Model $m)
    {
        $result = $this->internal->hgetall($this->prefix . $m->getName() . "*");
        if (empty($result)) throw new Exception("Items not found in cache...");
        return $result;
    }
    function set(Model $m)
    {
        foreach ($m->getBody()->getParams() as $field => $value) {
            $this->internal->hset($this->getKeyWithPrefix($m), $field, $value);
        }
    }
    function setAll(array $entries)
    {
        foreach ($entries as $m) {
            $this->set($m);
        }
    }
    function invalidate(Model $m)
    {
        $this->internal->expire($this->getKeyWithPrefix($m), 10);
    }

    function ttl(Model $m)
    {
        return $this->internal->ttl($this->getKeyWithPrefix($m));
    }
}
