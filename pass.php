<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>APS</title>
</head>
<body>
    <section>
        <form action="" method="post">
            1. <input name="q1" type="text" size="100" 
                value="¿Tiene o ha tenido alguna enfermedad que requirió hospitalización?">
                <br>
            2. <input name="q2" type="text" size="100" 
                value="¿Tiene o ha tenido algún tipo de cáncer?">
                <br>
            3. <input name="q3" type="text" size="100" 
                value="¿Tiene o ha tenido problemas o enfermedades cardíacas?">
                <br>
            4. <input name="q4" type="text" size="100" 
                value="¿Ha sido sometido a alguna operación quirúrgica en los últimos tres años?">
                <br>
            5. <input name="q5" type="text" size="100" 
                value="¿Fuma más de diez cigarrillos diarios?">
                <br>
            6. <input name="q6" type="text" size="100" 
                value="¿Tiene Sida o es portador del virus de la inmunodeficiencia humana - VIH?">
                <br>
            <input type="submit" value="Registrar">
        </form>
    </section>
    <br><br>
</body>
</html>

<?php
/*function crypt_pass($password, $digito = 7) {
	$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
	$salt = sprintf('$2x$%02d$', $digito);
	
	for($i = 0; $i < 22; $i++){
		$salt .= $set_salt[mt_rand(0, 63)];
	}
	
	return crypt($password, $salt);
}

echo crypt_pass('pw4admin');

$pass_bd = '$2x$07$zcfSZ2.sE.jOSZdcCGK0geXOjt98pv2iUM22AIdJl.gcjgwYMd44S';

if(crypt('pw4admin', $pass_bd) == $pass_bd) {
	echo "<br>OK";
}
*/
set_time_limit(0);

require_once 'app/config/administrator.php';
require_once 'app/controllers/ReportDEEcofuturoController.php';
require_once 'app/controllers/ReportDESartawiController.php';
require_once 'app/controllers/ReportDEEmprenderController.php';
require_once 'app/controllers/ReportDEPauloviController.php';
require_once 'app/controllers/ReportDEIdeproController.php';
require_once 'app/controllers/ReportDECrecerController.php';

class APS extends Administrator
{

    public $qs = array();
    private $queryset, $rs, $row, $cx;
    
    function __construct()
    {
        parent::__construct();
    }

    public function setDataQuestion()
    {
        $this->queryset = 'select 
            sef.nombre as ef_nombre,
            sef.codigo as ef_codigo,
            sef.db_host,
            sef.db_database,
            sef.db_user,
            sef.db_password
        from sa_entidad_financiera as sef
        where sef.activado = true
        ;';

        if (($this->rs = $this->query($this->queryset, MYSQLI_STORE_RESULT)) !== false) {
            if ($this->rs->num_rows > 0) {
                while ($this->row = $this->rs->fetch_array(MYSQLI_ASSOC)) {
                    if ($this->connectDB() === true) {
                        $token = false;

                        switch ($this->row['ef_codigo']) {
                        case 'EC':
                            $ecofuturo = new ReportDEEcofuturoController($this->cx, null, null, null);
                            $token = $ecofuturo->apsEcofuturo($this->qs);
                            break;
                        case 'SS':
                            $sartawi = new ReportDESartawiController($this->cx, null, null, null);
                            $token = $sartawi->apsSartawi($this->qs);
                            break;
                        case 'EM':
                            $emprender = new ReportDEEmprenderController($this->cx, null, null, null);
                            $token = $emprender->apsEmprender($this->qs);
                            break;
                        case 'PV':
                            $paulovi = new ReportDEPauloviController($this->cx, null, null, null);
                            $token = $paulovi->apsPauloVI($this->qs);
                            break;
                        case 'ID':
                            $idepro = new ReportDEIdeproController($this->cx, null, null, null);
                            $token = $idepro->apsIdepro($this->qs);
                            break;
                        case 'CR':
                            $crecer = new ReportDECrecerController($this->cx, null, null, null);
                            $token = $crecer->apsCrecer($this->qs);
                            break;
                        }

                        if ($token === true) {
                            echo $this->row['ef_nombre'] . ' ->> OK <br>';
                        } else {
                            echo $this->row['ef_nombre'] . ' ->> Error <br>';
                        }


                        $this->cx->close();
                    }
                }
            }
        }
    }

    private function connectDB()
    {
        $this->cx = new mysqli(
            $this->row['db_host'], 
            $this->row['db_user'], 
            $this->row['db_password'], 
            $this->row['db_database']);

        if ($this->cx->connect_error) {
            return false;
        }

        return true;
    }

    
}

if ($_POST) {
    $aps = new APS();

    $number = count($_POST);
    $tags = array_keys($_POST);
    $values = array_values($_POST);

    for ($i = 0; $i < $number; $i++) { 
        $aps->qs[$i + 1] = $values[$i];
    }

    $aps->setDataQuestion();
}
?>