<?php
class ConfigurationModel extends Model
{
    function __construct()
    {
        parent::__construct([
            'name' => "configs",
            'keys' => ["cid:d"],
            'body' => ['cid:d', 'aid:d', 'amount:d', 'start:d', 'end:d', 'size:d']
        ]);
    }
}
