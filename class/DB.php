<?php
/**
 * DB 
 * @package	
 * @author	LiJie <npcmib@gmail.com>
 */
include_once '/define.inc.php';
class DB
{

	protected $_dbh = null;
    protected $_insert_id = 0;

	public function __construct()
	{
		$this->connect_db();
	}
	
	public function connect_db()
	{
		$dsn = DB_TYPE . ":host=" . DB_HOST . ";port=". DB_PORT.";dbname=" . DB_NAME;
		$options = array(
            PDO::ATTR_PERSISTENT    => DB_PCONNECT,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
        );

		try {
		    $this->_dbh = new PDO($dsn, DB_USER, DB_PASS, $options);
			$this->_dbh->exec("set names " . DB_CHARSET);
			
		} catch (PDOException $e) {
			if(!($this->_dbh instanceof PDOStatement)) die("Cannot Connect DB.");
			throw $e;
		}
		
	}
	
	public function query( $sql, $ary = array())
	{
		$sth = $this->_dbh->prepare($sql);
		
		try {
			$sth->execute($ary);
			$return_val	= 0;
            if ( preg_match( 
                '/^\s*(create|alter|truncate|drop)\s/i', $sql ) 
            ) {
                $return_val = $this->_dbh;

            }elseif ( preg_match( 
                '/^\s*(insert|delete|update|replace)\s/i', $sql ) ) 
			{
				$this->rows_affected = $sth->rowCount();
			    $return_val = $this->rows_affected;

				if ( preg_match( '/^\s*(insert|replace)\s/i', $sql ) ) 
				{
					$this->_insert_id = $this->_dbh->lastInsertId();
                    $return_val = $this->_insert_id;
				}
			}
			else
			{
				$return_val = $sth->fetchAll(PDO::FETCH_ASSOC);
			}

			return $return_val;
		} 
		catch (PDOException $e) 
		{
			throw $e;
		}
		return false;
	}

	public function insert( $sql, $ary = array() )
	{
		return $this->query( $sql, $ary );
	}

	public function update( $sql, $ary = array() )
	{
		return $this->query( $sql, $ary );
	}

	public function delete( $sql, $ary = array() )
	{
		return $this->query( $sql, $ary );
	}
    
    public function getLastId()
    {
        return $this->_insert_id;
    }

	public function row( $sql, $ary = array(), $mode = PDO::FETCH_ASSOC )
	{	
		$return_val = array();
		$sth = $this->_dbh->prepare( $sql );
		try {
			$sth->execute($ary);
			$return_val	= 0;
			if( preg_match( '/^\s*(select)\s/i', $sql) )
			{
				$return_val = $sth->fetch($mode);
			}
			return $return_val;
		}
		catch ( PDOException $e ) 
		{
			throw $e;
		}
	
		return false;
	}
	
	public function beginTransaction()
	{
		$this->_dbh->beginTransaction();
	}

	public function rollBack()
	{
		$this->_dbh->rollBack();
	}

	public function commit()
	{
		$this->_dbh->commit();
	}

	public function close()
	{
		$this->_dbh = null;
	}

	public function __destruct(){
		$this->close();
	}
}
?>
