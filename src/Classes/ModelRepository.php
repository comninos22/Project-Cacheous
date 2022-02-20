<?php
class ModelRepository implements IRepository
{
    public $db, $redis;
    function __construct()
    {
        $this->db = DB::getInstance();
    }
    function findAll(Model $m)
    {
        return $this->db->run("SELECT * FROM " . $m->getName())->fetchAll();
    }
    function findOne(Model $m)
    {
        return $this->db->run("SELECT * FROM " . $m->getName() . " WHERE " . $m->getKey()->extractSqlKey())->fetchAll();
    }
    function insert(Model $m)
    {
        return $this->db->run("INSERT INTO " . $m->getName() . " (" . $m->getBody()->getInsertKeys() . ") INTO (" . implode(",", $m->getBody()->getInsertValues()) . ")")->rowCount();
    }
    function update(Model $m)
    {
        return $this->db->run("UPDATE " . $m->getName() . " SET (" . $m->getBody()->getUpdatePairs() . ") WHERE " . $m->getKey()->extractSqlKey())->rowCount();
    }
    function delete(Model $m)
    {
        return $this->db->run("DELETE FROM " . $m->getName() . " WHERE " . $m->getKey()->extractSqlKey())->rowCount();
    }
}