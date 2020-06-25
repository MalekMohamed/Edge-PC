<?php

/**
 * Created by PhpStorm.
 * User: Legacy
 * Date: 100050/11/2017
 * Time: 3:32 PM
 */
class Config extends PDO
{
    public $Date = "d-M-Y h:i a";
    private $db = array(
        "host" => 'localhost',
        "user" => 'root',
        "password" => '68426842',
        "db_name" => 'gaming',
    );
    public $per_page = 15;
    public $siteName = "Edge Store";
    public $Facebook = "https://www.facebook.com/Conquer.Hubs";
    public $gmail = array(
        'email' => 'mail@domain.com',
        'password' => 'password'
    );
    public $conn;


    public function BASE_URL($link)
    {
        /* if you Put the WebSite Files in a Folder inside your WWW Folder or Htdoc Folder Put the folder name Here
                                                ↓             */
        return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $link;

    }

    public function Close_connection()
    {
        $this->conn = NULL;
        echo '<script type="application/javascript">';
        echo 'console.log(\'connection Ended\')';
        echo '</script>';
    }

    public function __construct()
    {
        $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
        $dsn = 'mysql:host=' . $this->db['host'] . ';dbname=' . $this->db['db_name'] . '';
        try {
            $this->conn = new PDO($dsn, $this->db['user'], $this->db['password'], $option);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// always disable emulated prepared statement when using the MxSQL driver
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die('<pre>Failed To Connect To Database Error -> ' . $e->getMessage() . ' ' . print_r(PDO::getAvailableDrivers()) . ' ' . phpversion() . '</pre>');
        }
        date_default_timezone_set('Africa/Cairo');
    }

    public function select($table, $fields, $where, $data)
    {
        if ($where == '' || empty($where)) {
            $cond = '';
            $data = '';
        } elseif (!is_array($where)) {
            $cond = '';
        } else {
            $cond = 'WHERE';
            $where = $this->where($where);
        }
        $query = $this->conn->prepare("SELECT $fields FROM $table $cond $where");
        if ($data == '') {
            $query->execute();
        } elseif (!is_array($data)) {
            $query->execute(array($data));
        } else {
            $query->execute($data);
        }
        return $query;
    }

    private function where($where)
    {
        if (is_array($where)) {
            if (count($where) > 1) {
                $where = implode(" AND ", $where);
            } else {
                $where = implode('', $where);
            }
        }
        return $where;
    }

    public function Object($array)
    {
        $object = '';
        if (is_array($array)) {
            $object = new stdClass();
            foreach ($array as $key => $value) {
                $object->{$key} = $value;
            }
        }
        return $object;
    }
}
