<?php
class Produkty{
	private $GID;
	private $Czas;
    private $ID_node;
    private $URL;
    private $Flash;
    private $Zdjecie;
    private $Instrukcja;
    private $Certyfikat;
    private $Sterowniki;
    private $Pudelko;
    private $Karta_katalogowa;
    private $Specyfikacja;
    private $Film;
    private $DescPr;
	public $status="";

	function __construct($a){
		$this->GID=$a->GID;
		$this->Czas=$a->Czas;
		$this->ID_node=$a->ID_node;
		$this->URL=$a->URL;
		$this->Flash=$a->Flash;
		$this->Zdjecie=$a->Zdjecie;
		$this->Instrukcja=$a->Instrukcja;
		$this->Certyfikat=$a->Certyfikat;
		$this->Sterowniki=$a->Sterowniki;
		$this->Pudelko=$a->Pudelko;
		$this->Karta_katalogowa=$a->Karta_katalogowa;
		$this->Specyfikacja=$a->Specyfikacja;
		$this->Film=$a->Film;
		$this->DescPr=$a->DescPr;
	}
	
	function __toString(){
		return (string)$this->GID;
	}
	
	function dodaj(){
		global $db;
		$query = $db->prepare('INSERT INTO katalog (`GID`, `Czas`, `ID_node`, `URL`, `Flash`, `Zdjecie`, `Instrukcja`, `Certyfikat`, `Sterowniki`, `Pudelko`, `Karta_katalogowa`, `Specyfikacja`, `Film`, `DescPr`) VALUES (:GID, :Czas,:ID_node,:URL,:Flash,:Zdjecie,:Instrukcja,:Certyfikat,:Sterowniki,:Pudelko,:Karta_katalogowa,:Specyfikacja,:Film,:DescPr)');
		if($query->execute(array(':GID' => $this->GID,':Czas'=>$this->Czas,':ID_node'=>$this->ID_node,':URL'=>$this->URL,':Flash'=>$this->Flash,':Zdjecie'=>$this->Zdjecie,':Instrukcja'=>$this->Instrukcja,':Certyfikat'=>$this->Certyfikat,':Sterowniki'=>$this->Sterowniki,':Pudelko'=>$this->Pudelko,':Karta_katalogowa'=>$this->Karta_katalogowa,':Specyfikacja'=>$this->Specyfikacja,':Film'=>$this->Film,':DescPr'=>$this->DescPr)))	
			return true;
		else
			return false;
	}

}
?>


