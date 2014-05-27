<?php

class Tx_Tarissement_Controller_AjaxController  extends Tx_Extbase_MVC_Controller_ActionController   {

	public function ajoutVacheAction() { 
		
		//On commence par récupérer les variables et les mettre en SESSION
		$nomVache = $_POST["nomVache"];
		$CCI = $_POST["CCI"];
		$mammiteClinique = $_POST["mammiteClinique"];
		$troisiemeLactation = $_POST["troisiemeLactation"];
		$plancherMamelle = $_POST["plancherMamelle"];
		$presencePlaies = $_POST["presencePlaies"];
		$lesionsTrayon = $_POST["lesionsTrayon"];
		$pertesLait = $_POST["pertesLait"];
		$trayonsCourts = $_POST["trayonsCourts"];
		
		//On enregistre les données en SESSION
		$tabVaches=$GLOBALS["TSFE"]->fe_user->getSessionData("tabVaches");
		
		$tabVaches[$nomVache] = array("CCI" => $CCI, "mammiteClinique" => $mammiteClinique,
										"troisiemeLactation" => $troisiemeLactation, "plancherMamelle" => $plancherMamelle, "presencePlaies" => $presencePlaies, "lesionsTrayon" => $lesionsTrayon,
										"pertesLait" => $pertesLait, "trayonsCourts" => $trayonsCourts);
		$GLOBALS["TSFE"]->fe_user->setAndSaveSessionData("tabVaches", $tabVaches);

		
		// Puis on prépare l'affichage dans le tableau	
		if(count($tabVaches) != 0) {
			$chaine = "<tr id='vache".$nomVache."'><td>";
			$chaine.= $nomVache;
			$chaine.= "</td><td>";
			$chaine.= $CCI;
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($mammiteClinique);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($troisiemeLactation);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($plancherMamelle);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($presencePlaies);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($lesionsTrayon);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($pertesLait);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($trayonsCourts);
			$chaine.= "</td><td><a href=\"javascript:recupVache('".$nomVache."');\" title=\"Modifier la ligne\" class=\"tx_tarissement_modifVache\" id=\"vache".$nomVache."\"></a></td>";
			$chaine.= "<td><a href=\"javascript:suppVache('".$nomVache."');\" title=\"Supprimer la ligne\" class=\"tx_tarissement_suppVache\" id=\"vache".$nomVache."\"></a></td></tr>";
			
		} else {
			$chaine = '<tr class="tx_tarissement_novache"><td colspan="10">Aucune vache rentrée</td></tr>';
		}
		
		return $chaine;
	
	}
	
	public function suppVacheAction() {
		// On récupère les variables POST
		$nomVache = $_POST["nomVache"];
		$tabVaches=$GLOBALS["TSFE"]->fe_user->getSessionData("tabVaches");
		unset($tabVaches[$nomVache]);
		$GLOBALS["TSFE"]->fe_user->setAndSaveSessionData("tabVaches", $tabVaches);
		
		if(count($tabVaches) == 0) {
			$chaine = '<tr class="tx_tarissement_novache"><td colspan="10">Aucune vache rentrée</td></tr>';
		} else {
			$chaine = '';
		}
		return $chaine;
		
	}
	
	public function recupVacheAction() {
		// On récupère les variables POST
		$nomVache = $_POST["nomVache"];
		
		$tabVaches=$GLOBALS["TSFE"]->fe_user->getSessionData("tabVaches");
		
		//On récupère les données de la vache et on construit la chaine de retour
		$chaine = $nomVache."###";
		foreach($tabVaches[$nomVache] as $nomCarac => $valueCarac) {
			$chaine .= $valueCarac."###";
		}
		
		return $chaine;
		
	}
	
	
	public function modifVacheAction() {
		// On récupère les variables POST
		$ancienNomVache = $_POST["ancienNomVache"];
		$nomVache = $_POST["nomVache"];
		$CCI = $_POST["CCI"];
		$mammiteClinique = $_POST["mammiteClinique"];
		$troisiemeLactation = $_POST["troisiemeLactation"];
		$plancherMamelle = $_POST["plancherMamelle"];
		$presencePlaies = $_POST["presencePlaies"];
		$lesionsTrayon = $_POST["lesionsTrayon"];
		$pertesLait = $_POST["pertesLait"];
		$trayonsCourts = $_POST["trayonsCourts"];
		
		//On enregistre les données en SESSION
		$tabVaches=$GLOBALS["TSFE"]->fe_user->getSessionData("tabVaches");
		
		$tabVaches[$nomVache] = $tabVaches[$ancienNomVache];
		$tabVaches[$nomVache] = array("CCI" => $CCI, "mammiteClinique" => $mammiteClinique,
										"troisiemeLactation" => $troisiemeLactation, "plancherMamelle" => $plancherMamelle, "presencePlaies" => $presencePlaies, "lesionsTrayon" => $lesionsTrayon,
										"pertesLait" => $pertesLait, "trayonsCourts" => $trayonsCourts);
		unset($tabVaches[$ancienNomVache]);
		$GLOBALS["TSFE"]->fe_user->setAndSaveSessionData("tabVaches", $tabVaches);

		// Puis on prépare l'affichage dans le tableau	
		if(count($tabVaches) != 0) {
			$chaine = "<tr id='vache".$nomVache."'><td>";
			$chaine.= $nomVache;
			$chaine.= "</td><td>";
			$chaine.= $CCI;
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($mammiteClinique);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($troisiemeLactation);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($plancherMamelle);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($presencePlaies);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($lesionsTrayon);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($pertesLait);
			$chaine.= "</td><td>";
			$chaine.= ucfirst ($trayonsCourts);
			$chaine.= "</td><td><a href=\"javascript:recupVacheForModif('".$nomVache."');\" title=\"Modifier la ligne\" class=\"tx_tarissement_modifVache\" id=\"vache".$nomVache."\"></a></td>";
			$chaine.= "<td><a href=\"javascript:suppVache('".$nomVache."');\" title=\"Supprimer la ligne\" class=\"tx_tarissement_suppVache\" id=\"vache".$nomVache."\"></a></td></tr>";
			
		} else {
			$chaine = '<tr class="tx_tarissement_novache"><td colspan="10">Aucune vache rentrée</td></tr>';
		}
		
		return $chaine;
		
	}
	
	
}




