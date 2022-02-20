<?php
class DB
{
    public $pdo;
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
        $default_options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($default_options, []);
        $dsn = "mysql:host=localhost;dbname=jb;port=3306;charset=utf8mb4";

        try {
            $this->pdo = new \PDO($dsn,  "root", "", $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    public function run($sql, $args = NULL)
    {
        if (!$args) {
            return $this->pdo->query($sql);
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }
}
