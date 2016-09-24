<?php

/**
 * Description of DB.
 *
 * @author edily
 */
abstract class Database implements DatabaseInterface
{
    protected $db;
    protected $host;
    protected $user;
    protected $password;
    protected $database;
    protected $port;
    protected $socket;
    protected $alias;
    protected $lastInsertId;
    protected $numRows = 0;
    protected $affectedRows = 0;
    public $lastQueryKey;

    private function connect()
    {
        $this->getConfig();
        $this->db = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        mysqli_set_charset($this->db, 'utf8');
    }
    
    public function query($query, $dbAlias = '')
    {
        $this->addQueryHistory($query);
        
        if (empty($this->alias) && !empty($dbAlias)) {
            $this->alias = $dbAlias;
        }

        $this->connect();
        $result = mysqli_query($this->db, $query) or die(mysqli_error($this->db).'<br/>'.$query);
        @$this->lastInsertId = (int) mysqli_insert_id($this->db);
        @$this->affectedRows = (int) mysqli_affected_rows($this->db);
        @$this->numRows = (int) mysqli_num_rows($result);
        $this->disconect();

        return $result;
    }

    public function select($query, $dbAlias = '')
    {
        if (empty($this->alias) && !empty($dbAlias)) {
            $this->alias = $dbAlias;
        }

        $dadosRet = array();
        $result = $this->query($query, $dbAlias);
        while ($dados = mysqli_fetch_array($result)) {
            array_push($dadosRet, $dados);
        }

        return $dadosRet;
    }

//    private function dbAuth(){        
//        $this->host = DB_HOST[$this->alias];
//        $this->user = DB_USER[$this->alias]; 
//        $this->password = DB_PASS[$this->alias]; 
//        $this->database = DB_NAME[$this->alias];
//    }

    private function disconect()
    {
        mysqli_close($this->db);
    }

    private function getConfig()
    {

        /*
         *  Sai caso haja config manual
         */
        if (!empty($this->host) ||
            !empty($this->user) ||
            !empty($this->password) ||
            !empty($this->database)) {
            return true;
        }

        $host = json_decode(DB_HOST, true);
        $user = json_decode(DB_USER, true);
        $password = json_decode(DB_PASS, true);
        $database = json_decode(DB_NAME, true);

        $this->host = $host[$this->alias];
        $this->user = $user[$this->alias];
        $this->password = $password[$this->alias];
        $this->database = $database[$this->alias];
    }
    
    private function addQueryHistory($query)
    {
        $this->lastQueryKey = time() . "-" . rand(0,1000);
        $queryHist = Register::get("queryHist");
        $queryHist = is_null($queryHist) ? array() : $queryHist;
        $queryHist[$this->lastQueryKey] = Query::removeLimitOffset($query);
        Register::set("queryHist", $queryHist);
    }
    
    public function getQueryHistory($queryKey)
    {
        $queryHist = Register::get("queryHist");
        return $queryHist[$queryKey];        
    }    
    
    public function getNumRows(){
        return $this->numRows;
    }
    
    public function getAffectedRows(){
        return $this->affectedRows;
    }
}
