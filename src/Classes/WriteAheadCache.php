<?php

class WriteAheadCache extends CacheAccessor
{
    function insert(Model $m)
    {
        $this->redis->set($m);
        if (!$this->db->insert($m) > 0) {
            var_dump($m);
            throw new Exception("Insert failed");
        }
        return true;
    }
}
