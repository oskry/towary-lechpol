<?php
require_once("katalog.class.php");
$db = new PDO('mysql:host=localhost;dbname=lechpol;charset=utf8', 'root', '');
$link = "http://www.lechpol.eu/towarynowe";

function pobierzPlik($file_url, $save_to){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_POST, 0); 
	curl_setopt($ch,CURLOPT_URL,$file_url); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
	$file_content = curl_exec($ch);
	curl_close($ch);
	$downloaded_file = fopen($save_to, 'w');
	fwrite($downloaded_file, $file_content);
	return fclose($downloaded_file);
}
	
function is_ajax() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
}


if (is_ajax()) {
	if (isset($_POST["action"]) && !empty($_POST["action"])) { 
		$action = $_POST["action"];
		if($action=="get_record_count"){	
			$xml=simplexml_load_file("towarynowe.xml") or die("Error: Nie można załadować pliku XML!");	
			echo $xml->count();	
		}elseif($action=="download_file"){
			if(pobierzPlik($link, "towarynowe.xml"))
				echo "Plik XML pobrany prawidłowo z serwera ".$link;
			else
				echo "Błąd pobrania pliku XML z serwera!";
				
			$query = $db->prepare('TRUNCATE TABLE katalog');
			if($query->execute())
				echo "\nBaza danych została wyczyszczona!";
			else
				echo "\nBłąd czyszczenia bazy danych!!";
		}elseif($action=="add_records"){
			$xml=simplexml_load_file("towarynowe.xml") or die("Error: Nie można załadować pliku XML!");	
			$wielkosc_buforu=$_POST["bufor"];
			$od	= $_POST['od']; 
			$do	= $od+$wielkosc_buforu;
			$dodane_gid="";
			for ($i = $od+1; $i <= $do; $i++) {
				if($xml->count()>$i){
					$produkty = new Produkty($xml->node[$i]);
					if($produkty->dodaj()) $produkty->status="DODANE"; else $produkty->status="BŁĄD";
					$dodane_gid=$dodane_gid."\nGID: ".$produkty." - ".$produkty->status."";
				}
			}
			echo $dodane_gid;
		}
	}
}
?>


