<?php 
class Tx_Tarissement_Vache {
	
	public $vache_nomVache;
	public $vache_CCI;
	public $vache_mammiteClinique;
	public $vache_troisiemeLactation;
	public $vache_plancherMamelle;
	public $vache_presencePlaies;
	public $vache_lesionsTrayon;
	public $vache_pertesLait;
	public $vache_trayonsCourts;
	
	
	public function setNomVache($nomVache) {
		$this->vache_nomVache = $nomVache;
	}
	
	public function setCarac($nameCarac, $valueCarac) {
		$this->{"vache_".$nameCarac} = $valueCarac;
	}
	
}

