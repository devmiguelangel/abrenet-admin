<?php 
/**
* Administrator MySQL
*/
class Administrator extends mysqli
{
	protected $err = false;

	private $data = array('mysql' => array(
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'sud_administrator',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => 'sa_',
        )
	);
	
	protected function __construct()
	{
		$data = $this->data['mysql'];
		@parent::__construct($data['host'], $data['username'], $data['password'], $data['database']);
		
		if (mysqli_connect_error()) {
			die('Error de Conexion (' . mysqli_connect_errno() . ' ) ' . mysqli_connect_error());
		}
	}
}

?>