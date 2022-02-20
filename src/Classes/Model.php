<?php


class Model implements IModel
{
    public EntityKey $key;
    public EntityBody $body;
    public string $name;
    function __construct($params)
    {
        if (!isset($params['name'])) throw new Exception("Can't refer to anything, set entity name");
        $this->name = $params["name"];
        if (isset($params['body'])) $this->body = new EntityBody($params['body']);
        if (isset($params['keys'])) $this->key = new EntityKey($params['keys']);
    }
    function getBody()
    {
        if ($this->body == null) throw new Exception("Trying to access null body..");
        return $this->body;
    }
    function getKey()
    {
        if ($this->key == null) throw new Exception("Trying to access null key..");
        return $this->key;
    }
    function getName()
    {
        return $this->name;
    }
}