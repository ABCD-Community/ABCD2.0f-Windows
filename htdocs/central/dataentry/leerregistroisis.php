<?php

function LeerRegistro($base,$cipar,$from,&$maxmfn,$Opcion,$login,$password,$Formato,$allow="") {
global $record_protection,$password_protection;
	$query="";
	if (isset($arrHttp["lock"])){
    	$query = "&base=" . $base . "&cipar=$db_path"."par/".$cipar. "&Mfn=" . $arrHttp["Mfn"]."&login=".$login;
    	include("../common/wxis_llamar.php");
    	$res=implode("|",$contenido);
    	$res=explode("|",$res);
    	$res=trim($res[0]);
    	if ($res!="LOCKGRANTED") {

    $query="";
    if (isset($arrHttp["unlock"])){
    	$IsisScript=$xWxis."unlock.xis";
    	$query = "&base=" . $base . "&cipar=$db_path"."par/".$cipar. "&Mfn=" . $arrHttp["Mfn"]."&login=".$login;
    	include("../common/wxis_llamar.php");
    	$res=implode("",$contenido);
    	$res=trim($res);
    	return $res;
    }
    unset($arrHttp["lock"]);
    unset($arrHttp["unlock"]);
    //SE LEE LA FDT DE LA BASE DE DATOS PARA EXTRAER TODOS LOS CAMPOS
    $archivo="$db_path$base/def/".$_SESSION["lang"]."/$base.fdt";
	if (file_exists($archivo))
		$fpTm = file($archivo);
	else
		$fpTm=file("$db_path$base/def/".$lang_db."/$base.fdt");
	$Pft="";
	if (!$fpTm){
		echo "<script>
			if (top.window.frames.length>0) top.xeditar=''\n";

		echo "</script>\n";
		die;
	$protect_record="";
	$record_protection="";
	$password_protection="";
	foreach ($fpTm as $linea){
		if (trim($linea)!="") {
			$t=explode('|',$linea);
			if ($t[7]=="PR") $protect_record=$t[1];
			if ($t[7]=="RP") {
			}
			if ($t[0]=="LDR"){
				$leader_tab="$db_path$base/def/".$_SESSION["lang"]."/leader.fdt";
				if (file_exists($leader_tab))
					$fpLeader = file($leader_tab);
				else
					$fpLeader=file("$db_path$base/def/".$lang_db."/leader.fdt");
							if ($tlead[0]!="LDR")
								$Pft.="if p(v".$tlead[1].") then '".$tlead[1]." 'v".$tlead[1]."'____$$$' fi,";
						}

  			if ($t[0]!="S" and $t[0]!="H" and $t[0]!="L" and $t[0]!="LDR"){
  					$Pft.="(if p(v".$t[1].") then '".$t[1]." 'v".$t[1]."'____$$$' fi),";
  		}

  	}
  	if ($protect_record!="")
  		$Pft.='"$$_$$"V'.$protect_record;
  	if ($record_protection!="")
  	    $Pft.='"$$_$$"V'.$record_protection;
	$IsisScript=$xWxis."leer.xis";
	$query = "&base=" . $base . "&cipar=$db_path"."par/".$cipar. "&Mfn=" . $arrHttp["Mfn"]."&Opcion=".$Opcion."&login=".$login."&password=".$password;

	if ($Formato!="")
		$query.="&Formato=".$arrHttp["Formato"];
	else
		if ($Pft!="") $query.="&Pft=".urlencode($Pft);
	unset($contenido);
	include("../common/wxis_llamar.php");
	unset($cont);
    $cont=implode("",$contenido);
    $cont=trim($cont);
    if (substr($cont,0,7)=="MAXMFN:"){
    	$maxmfn=substr($cont,7,$ix-7);
		$arrHttp["Maxmfn"]=$maxmfn;
    	$cont=substr($cont,$ix+2);
    $c=explode('$$_$$',$cont);
    if (isset($c[1])){
    }else{
    $contenido=explode('____$$$',$c[0]);
 	$valortag=array();
 	$ic=2;
 	foreach($contenido as $linea){
 		if (trim($linea)!=""){
				$linea=trim(substr($linea,0,strlen($linea)-4));
				$arr=explode('##',$linea);
		   		$mfn=substr(trim($arr[1]),4);
		   		$ic=2;
				$arrHttp["Mfn"]=$mfn;
				$arrHttp["Maxmfn"]=substr(trim($arr[0]),7);
				$maxmfn=$arrHttp["Maxmfn"];
		  	}else{
		   		$linea=trim($linea);
		   		if ($linea!=""){
		    		$pos=strpos($linea, " ");
		    		if (is_integer($pos)) {
		     			$tag_x=trim(substr($linea,0,$pos));
		////El formato ALL env�a un <br> al final de cada l�nea y hay que quitarselo
						if (is_numeric($tag_x) and $tag_x!=""){
				    		$linea=substr($linea, $pos+1);
				    		$tag=$tag_x;
							if ($tag==1002){
					 			$maxmfn=$linea;
							}else{
				     			if (!isset($valortag[$tag])){
				      				$valortag[$tag]=$linea;
				     			}else {
				     	 			$valortag[$tag]=$valortag[$tag]."\n".$linea;
				     			}
				    		}
						}
		   			}else{

		   			}
		  		}
		 	}
		}
	}

 	if (isset($valortag[1102])){
		 	echo "<h1>".$msgstr["recdel"]."</h1>";
		 	$record_deleted="Y";
	 		return;
	 	}
    }
    $record_deleted="N";
 	if (isset($valortag["1002"])) $maxmfn=$valortag["1002"];

}

function LeerRegistroFormateado($Formato) {

global $valortag,$xWxis,$arrHttp,$tagisis,$msgstr,$db_path,$Wxis,$wxisUrl,$lang_db,$MaxMfn,$record_deleted,$def;
	if (!isset($arrHttp["Formato"])) $arrHttp["Formato"]="";
 	if ($Formato=="" or (isset($arrHttp["Formato"]) and $arrHttp["Formato"]=="ALL")) {
 		$arrHttp["Formato"]="ALL";
 	}else{
 		if (file_exists($db_path.$arrHttp["base"]."/pfts/".$_SESSION["lang"]."/" .$Formato.".pft")){
 		}else{
        }
 	}

 	$IsisScript=$xWxis."buscar.xis";
 	$query = "&cipar=$db_path"."par/".$arrHttp["cipar"]. "&Mfn=" . $arrHttp["Mfn"]."&Opcion=".$arrHttp["Opcion"]."&base=" .$arrHttp["base"]."&Formato=$Formato";
	include("../common/wxis_llamar.php");
	$salida="";
	$record_deleted="N";
 	if ($arrHttp["Formato"]=="ALL") {
 		$salida="<font size=3><xmp>";
		foreach ($contenido as $linea) {
			$linea=str_ireplace('<BR>',"\n",$linea);
			$linea=str_ireplace('<BR \>',"\n",$linea);
		 	if ($linea=='$$DELETED'){
		 		$record_deleted="Y";

		 		$salida.= $arrHttp["Mfn"]." ".$msgstr["recdel"];
		 	}else{
			 	$salida.=$linea;
		 	}
		}
		$salida.= "</xmp></font>";
	 }else{
	  	foreach ($contenido as $linea) {
	  		$lines=trim($linea);
	 			$ref=substr($linea,6);
	 			$f=explode(",",$ref);
	 			$bd_ref=trim($f[0]);
	 			$pft_ref=trim($f[1]);
	 			$expr_ref=trim($f[2]);
	 			$ixp=strpos($expr_ref,'_');

	 			if ($ixp>0){
	 			    $pref_rel=trim(substr($expr_ref,0,$ixp+1));
	 				$expr_ref=trim(substr($expr_ref,$ixp+1));
	 				$b_rel=explode('$$',$expr_ref);
	 				$expr_ref="";
	 				foreach ($b_rel as $xx){
	 					if ($expr_ref==""){

	 			$reverse="";
	 			if (isset($f[3]) and $f[3]=="reverse")
	 				$reverse="ON";
	 			$IsisScript=$xWxis."buscar.xis";
	 			if (file_exists($db_path.$bd_ref."/pfts/".$_SESSION["lang"]."/" .$pft_ref.".pft")){
 					$pft_ref=$db_path.$bd_ref."/pfts/".$_SESSION["lang"]."/" .$pft_ref;
 				}else{
 					$pft_ref=$db_path.$bd_ref."/pfts/".$lang_db."/" .$pft_ref;
        		}
 				$query = "&cipar=$db_path"."par/".$bd_ref. ".par&Expresion=".$expr_ref."&Opcion=buscar&base=".$bd_ref."&Formato=$pft_ref&prologo=NNN&count=90000";
				if ($reverse!=""){
				$debug_x=1;
				include("../common/wxis_llamar.php");
				$ixcuenta=0;
				foreach($contenido as $linea_alt) {
					if (trim($linea_alt)!=""){
						$ll=explode('|^',$linea_alt);
						if (isset($ll[1])){
							$ixcuenta=$ixcuenta+1;
							$SS[trim($ll[1])."-$ixcuenta"]=$ll[0];
						}else{
							$salida.= "$linea_alt\n";
						}
					}
				}
				if (isset($SS) and count($SS)>0){
					ksort($SS);
					foreach ($SS as $linea_alt)
						$salida.= "$linea_alt\n";
				}
	  			if (strpos($linea,'$$DELETED')===false){
			 		$salida.= $linea."\n";
		 		}else{
		  			$salida.= "<h1> ".$arrHttp["Mfn"]." ".$msgstr["recdel"]."</h1>";
		  			$record_deleted="Y";
				}
		 	}
	  	}
	 }
	 return $salida;
}
?>