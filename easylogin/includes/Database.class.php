<?php
/**
* Database
*/
class Database
{
	public  $_pdo,
			$_query,
			$_table,
			$_error = false,
			$_results = array(),
			$_where,
			$_sql,
			$_bind = array(),
			$_count = 0,
			$_limit,
			$_orderby;

	public function __construct()
	{
		$EL = EasyLogin::getInstance();
		$db = $EL->config_item('db');

		try {
			$this->_pdo = new PDO('mysql:host='.$db['host'].';dbname='.$db['name'], $db['user'], $db['pass']);
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	private function query() 
	{
		if (!empty($this->_where)) {
			$this->_sql .= ' WHERE ' . $this->_where;
		}

		if (!empty($this->_orderby)) {
			$this->_sql .= ' ORDER BY ' . $this->_orderby;
		}

		if (!empty($this->_limit)) {
			$this->_sql .= ' LIMIT ' . $this->_limit;
		}

		return $this->run();
	}

	private function run()
	{
		$sql  = $this->_sql;
		$bind = $this->_bind;
		$this->reset();

		if ($this->_query = $this->_pdo->prepare($sql)) {
			if (count($bind)) {
				$k = 1;
				foreach ($bind as $value) {
					$this->_query->bindValue($k, $value);
					$k++;
				}
			}

			if ($this->_query->execute()) {
				return true;
			}

		}

		$this->_error = true;
		return false;
	}

	public function select($fields = '*', $table = '') 
	{
		$this->_sql = "SELECT $fields";
		if (!empty($table)) {
			$this->_sql .= " FROM $table";
		}

		return $this;
	}

	public function insert($table, $data = array())
	{
		$fields = ''; $values = '';
		
		if (count($data)) {
			foreach ($data as $key => $value) {
				$fields .= $key . ',';
				$values .='?,';
				$this->_bind[] = $value;
			}
			$fields = substr($fields, 0, strlen($fields)-1);
			$values = substr($values, 0, strlen($values)-1);
		}

		$this->_sql = "INSERT INTO $table ($fields) VALUES ($values)";

		return $this->query();
	}

	public function insert_id()
	{
		return $this->_pdo->lastInsertId();
	}

	public function update($table, $data)
	{
		$fields = '';
		$bind = $this->_bind;
		$this->_bind = array();

		if (count($data)) {
			foreach ($data as $key => $value) {
				$fields .= $key . ' = ?,';
				$this->_bind[] = $value;
			}
			$fields = substr($fields, 0, strlen($fields)-1);
		}

		$this->_sql = "UPDATE $table SET $fields";
		if (count($bind)) {
			foreach ($bind as $value) {
				$this->_bind[] = $value;
			}
		}

		return $this->query();
	}

	public function delete($table, $where = null)
	{
		$this->_sql = "DELETE FROM $table";
		if ($where) {
			$this->where($where[0], $where[1], @$where[2]);
		}
		return $this->query();
	}

	public function get($table = '', $fields = '*') {
		if (empty($this->_sql)) {
			$this->_sql = "SELECT $fields";
		}

		if (!empty($table)) {
			$this->_sql .= " FROM $table";
		}	
		
		if ( $this->query() ) {
			$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
			$this->_count = $this->_query->rowCount();

			return $this->_results;
		}

		return false;
	}

	public function limit($limit, $range = null)
	{
		if (is_numeric($limit)) {
            $this->_limit = $limit;

            if (!empty($range) && is_numeric($range)) {
	            $this->_limit .= ", $range";
	        }
        }
        return $this;
    }

    public function orderby($fields, $order = 'ASC')
    {
        if (!is_array($fields)) {
            $fields = array($fields);
        }

        foreach($fields as $f) {
            $f = $f . " " . $order;
            if (!empty($this->_orderby)){
            	$this->_orderby .= ", " . $f;
            } else {
            	$this->_orderby = $f;
            }
        }

        return $this;
    }

	public function where($key, $value, $operator = '=')
	{
		$operators = array('=', '!=', '<', '>', '>=', '<=', 'IN');
		if (!in_array($operator, $operators)) {
			$operator  = '=';
		}

		if (!empty($this->_where)) {
			$this->_where .= ' AND ';
		}

		$this->_where .= " $key $operator ? ";
		$this->_bind[] = $value;

		return $this;
	}

	public function or_where($key, $value, $operator = '=')
	{
		$operators = array('=', '!=', '<', '>', '>=', '<=', 'IN');
		if (!in_array($operator, $operators)) {
			$operator  = '=';
		}

		if (!empty($this->_where)) {
			$this->_where .= ' OR ';
		}

		$this->_where .= " $key $operator ? ";
		$this->_bind[] = $value;

		return $this;
	}

	public function where_in($key, $values)
	{
		$values = implode(', ', $values);
		return $this->where($key, $values, 'IN');
	}

	public function error()
	{
		return $this->_error;
	}
	
	private function reset()
	{
		$this->_error = false;
		$this->_sql = '';
		$this->_where = '';
		$this->_limit = '';
		$this->_orderby = '';
		$_count = 0;
		$this->_bind = array();
		$this->_results = array();
	}
}