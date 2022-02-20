<?php
interface IRepository
{
    function findOne(Model $k);
    function findAll(Model $m);
    function insert(Model $e);
    function update(Model $e);
    function delete(Model $e);
}
