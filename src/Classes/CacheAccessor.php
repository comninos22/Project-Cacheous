<?php
abstract class CacheAccessor implements IRepository
{
    public Redis $redis;
    public ModelRepository $db;
    function __construct()
    {
        $this->db = new ModelRepository();
        $this->redis = Redis::getInstance();
    }

    function update(Model $m)
    {
        if ($this->db->update($m) > 0)
            $this->redis->invalidate($m);
        else {
            var_dump($m);
            throw new Exception("Update failed");
        }
    }
    function delete(Model $m)
    {
        if ($this->db->delete($m) > 0)
            $this->redis->invalidate($m);
        else {
            var_dump($m);
            throw new Exception("Delete failed");
        }
    }
    function findAll(Model $m)
    {
        try {
            $results = $this->redis->getAll($m);
        } catch (Exception $e) {
            $results = $this->db->findOne($m);
            $entries = [];
            foreach ($results as $result) {
                $class = get_class($m);
                $entry = new $class;
                $entry->getBody()->setParams($result);
                $entries[] = $entry;
            }
            $this->redis->setAll($entries);
        }
        if (count($results) == 0) throw new Exception();
        $m->getBody()->setParams($results);
        return $m;
    }
    function findOne(Model $m)
    {
        try {
            $cacheResult = $this->redis->get($m);
        } catch (Exception $e) {
            echo $e->getMessage();
            if (!($dbResult = $this->db->findOne($m))) {
                throw new Exception("Didn't find anything...");
            }
            $m->getBody()->setParams($dbResult);
            try {
                $this->redis->set($m);
            } catch (Exception $e) {
                echo "Cache couldn't be updated";
            }
            return $m;
        }
        $m->getBody()->setParams($cacheResult);
        return $m;
    }
}
