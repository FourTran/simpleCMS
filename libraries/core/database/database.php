<?php
/**
 * @author F4urTran
 * @copyright Find All Together
 * @link f4urtran.com
 * @version 1.0
 * This is core file which manupulate database instructions
 * It is using PDO connection
 * MAll functions are using prepare statements
 */
// security check
if(!isset($security_check))
{
    echo "This is restricted file";
    exit();
}
/**
 * class for mysql database
 */
class MysqlDatabase
{
    // defining secrete variables
    private $db_name= DATABASE_NAME;
    private $db_user= DATABASE_USER;
    private $db_pass= DATABASE_PASS;
    private $db_server= DATABASE_SERVER;
    // protected PDO connection
    protected $con;

    /**
	 * setting database configuration
	 */
	function set_config($server,$db,$user,$pass)
	{
	    $this->db_server=$server;
	    $this->db_name=$db;
	    $this->db_user=$user;
	    $this->db_pass=$pass;
	}
	/**
	* connecting with a mysql database
	**/
	private function connect()
	{
		$info = 'mysql:host='.$this->db_server.';dbname='.$this->db_name;
		try{
			$this->con = new PDO($info, $this->db_user, $this->db_pass);
		} catch(PDOException $e)
		{
			header('HTTP/1.1 500 Database error');
			exit;
		}
		if(!$this->con)
		{
			die('Could not connect '.msql_error());
		}
	}
	/**
	* disconnecting database
	**/
	private function disconnect()
	{
		$this->con = null;
	}
	/**
	* quoting string
	* @param String $arg
	* @return String $arg
	**/
	function quote($arg)
	{
		$this->connect();
		$arg = $this->con->quote($arg);
		$this->disconnect();
		return $arg;
	}

	/** 
	* prepare state for single fetch
	* @param String $sql
	* @param Array $arg
	* @return Query $query
	**/
	function prepare($sql, $arg)
	{
		$this->connect();
		$query = $this->con->prepare($sql);
		$query->execute($arg);
		$this->disconnect();
		return $query;
	}
	/**
     * Return array of results
     * @param string $sql
     * @param array $args
     * @return query array $rows
     */
    function load_result($sql,$args)
    {
        $this->connect();
        $q = $this->con->prepare($sql);
        $q->execute($args);
        $rows = $q->fetchAll();
        $this->disconnect();
        return $rows;
    }
    /**
     * Return single result
     * @param string $sql
     * @param array $args
     * @return query $row
     */
    function load_single_result($sql,$args)
    {
        $this->connect();
        $q = $this->con->prepare($sql);
        $q->execute($args);
        $row = $q->fetch();        
        $this->disconnect();
        return $row;
    }
}
?>