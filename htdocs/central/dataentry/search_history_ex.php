<?php
session_start();
if (!isset($_SESSION["permiso"])){
	header("Location: ../common/error_page.php") ;
}

error_reporting(E_ALL);
include("../common/get_post.php");
include ('../config.php');
include("../lang/admin.php");
include("../lang/dbadmin.php");

//foreach ($arrHttp as $var=>$value) echo "$var=$value<br>"; //die;
//if (!isset($arrHttp["base"])) die;
if (!isset($_SESSION["history"])){
	die;
if (isset($arrHttp["Opcion"]) and ($arrHttp["Opcion"])=="clear"){
		$h=explode('$$|$$',$history);
		if ($h[0]==$base){
			unset($_SESSION["history"][$key]);
	}
	header("Location: inicio_base.php?base=$base");
	die;

//sort($_SESSION["history"]) ;
$history= $_SESSION["history"][$arrHttp["number"]-1];
$h=explode('$$|$$',$history);
$base=$h[0];

?>

<script>

		top.Expresion="<?php echo urlencode($h[1])?>"
		top.Menu("ejecutarbusqueda")
</script>