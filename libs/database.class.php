<?php

class database extends PDO
{
    private $host = DB_HOST;
    private $port = DB_PORT;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_DBNAME;

    private $_db;
    private $error;

    private $stmt;

    public function __construct()
    {
        // set DSN
        $sdn = 'pgsql:host=' . $this->host . ';port=' . $this->port . ';dbname=' . $this->dbname . ';user=' . $this->user . ';password=' . $this->pass;

        // set options
        $options = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);

        //create a new PDO instanace
        try {
            $this->_db = new PDO($sdn, $this->user, $this->pass, $options);
        } catch (Exception $e) {
            echo $e->getMessage();
            $this->error = $e->getMessage();
        }
    }

    /**
     * @param string $sql
     */
    public function  query($sql)
    {
        $this->stmt = $this->_db->prepare($sql);
    }

    /**
     * @param $params_arry
     */
    public function  bind($params_arry)
    {
        foreach ($params_arry as $param => $value) {
            $type = isset($p['type']) ? $p['type'] : NULL;
            if (is_null($type)) {
                switch (true) {
                    case is_int($value);
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value);
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value);
                        $type = PDO::PARAM_NULL;
                        break;

                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }
    }

    /**
     * @return mixed
     */
    public function execute()
    {
        return $this->stmt->execute();
    }

    /**
     * @return mixed
     */
    public function findAll()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function findOne()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @return mixed
     */
    public function  rowCount()
    {
        return $this->stmt->rowCount();
    }

    /**
     * @param null $seq_name
     * @return string
     */
    public function lastInserId($seq_name = NULL)
    {
        return $this->_db->lastInsertId($seq_name);
    }

    /**
     * @param $tableName
     * @param $data
     * @return bool|string
     */
    public function insert($tableName, $data)
    {
        $files = array_keys($data);
        $params = ':' . implode(',:' . $files);
        $files = implode(',' . $files);
        $sql = "INSERT INTO $tableName ($files) VALUE ($params)";
        $this->query($sql);
        $data->$this->renameKey($data, ':');
        $this->bind($data);
        try {
            $this->execute();
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return true;
    }

    /**
     * @param $arr
     * @param $prefix
     * @return mixed
     */
    private function renameKey($arr, $prefix)
    {
        foreach ($arr as $key => $value) {
            $arr[$prefix . $key] = $value;
            unset($arr[$key]);
        }
        return $arr;
    }
}

require __DIR__ . '/config.php';

