<?php
class WriteThroughCache extends CacheAccessor
{
    function insert(Model $m)
    {
        if (!$this->db->insert($m) > 0) {
            var_dump($m);
            throw new Exception("Insert failed");
        }
        return true;
    }
}
