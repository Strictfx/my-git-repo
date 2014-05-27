<?php

class Tx_Tarissement_Controller_TarissementfrontController  extends Tx_Extbase_MVC_Controller_ActionController   {

	/**
   * Affichage de la première étape
   *
   * @return void
   */ 
	public function situationTroupeauAction() { 
		
		$tabVarSession = $GLOBALS["TSFE"]->fe_user->getSessionData("tabRepForm");
		
		if(!empty($tabVarSession)) {
			$pourcentageCCI = $tabVarSession["pourcentageCCI"];
			$resultatTraitement = $tabVarSession["resultatTraitement"];
			$triLait = $tabVarSession["triLait"];
			$niveauTraitement = $tabVarSession["niveauTraitement"];
			
			$speIntraSaines = $tabVarSession["speIntraSaines"];
			$speInjectSaines = $tabVarSession["speInjectSaines"];
			$obtTrayonSaines = $tabVarSession["obtTrayonSaines"];
			$speIntraInfect = $tabVarSession["speIntraInfect"];
			$speInjectInfect = $tabVarSession["speInjectInfect"];
			$obtTrayonInfect = $tabVarSession["obtTrayonInfect"];
		} else {
			$pourcentageCCI = $resultatTraitement = $triLait = $niveauTraitement = "";
			$speIntraSaines = $speInjectSaines = $obtTrayonSaines = $speIntraInfect = $speInjectInfect = $obtTrayonInfect = "";
		}
		
		$this->view->assign("pourcentageCCI", $pourcentageCCI);
		$this->view->assign("speIntraSaines", $speIntraSaines);
		$this->view->assign("speInjectSaines", $speInjectSaines);
		$this->view->assign("obtTrayonSaines", $obtTrayonSaines);
		$this->view->assign("speIntraInfect", $speIntraInfect);
		$this->view->assign("speInjectInfect", $speInjectInfect);
		$this->view->assign("obtTrayonInfect", $obtTrayonInfect);
		
		if($resultatTraitement == "oui") {
			$this->view->assign("resultatTraitement", 'true');
		} else {
			$this->view->assign("resultatTraitement", 'false');
		}
		if($triLait == "oui") {
			$this->view->assign("triLait", 'true');
		} else {
			$this->view->assign("triLait", 'false');
		}
		if($niveauTraitement == "haut") {
			$this->view->assign("niveauTraitement", 'true');
		} else {
			$this->view->assign("niveauTraitement", 'false');
		}
		
	}
	
	/**
   * Traitement du premier formulaire et mise en session des réponses
   *
   * @param  string $pourcentageCCI 
   * @param  string $resultatTraitement 
   * @param  string $triLait 
   * @param  string $niveauTraitement 
   * @param  string $speIntraSaines 
   * @param  string $speInjectSaines 
   * @param  string $obtTrayonSaines 
   * @param  string $speIntraInfect 
   * @param  string $speInjectInfect 
   * @param  string $obtTrayonInfect 
   *
   * @return void             redirect to SituationVaches
   */ 
	public function situationTroupeauFormAction($pourcentageCCI, $resultatTraitement, $triLait, $niveauTraitement, $speIntraSaines, $speInjectSaines, $obtTrayonSaines,
																	$speIntraInfect, $speInjectInfect, $obtTrayonInfect) {
		if(empty($speIntraSaines) && empty($speInjectSaines) && empty($obtTrayonSaines) && empty($speIntraInfect) && empty($speInjectInfect) && empty($obtTrayonInfect)) {
			$this->view->assign("erreur", "Nous vous conseillons de consulter votre vétérinaire pour revoir votre protocole de soin avant d'utiliser cet outil.");
		} elseif($resultatTraitement == "oui" || $triLait == "oui") { 
			$this->view->assign("erreur", "Le tri du lait que vous effectuez pour limiter la hausse de concentration cellulaire fait que les résultats enregistrés
											ne sont pas révélateur du niveau d'infection mammaire de votre troupeau.\n\r
											Nous vous conseillons d'utiliser cet outil après consultation de votre vétérinaire.");
		} else {
			//Enregistrement en session des variables
			$tabVarSession = array("pourcentageCCI" => $pourcentageCCI, "resultatTraitement" => $resultatTraitement, "triLait" => $triLait, "niveauTraitement" => $niveauTraitement, 
												"speIntraSaines" => $speIntraSaines, "speInjectSaines" => $speInjectSaines, "obtTrayonSaines" => $obtTrayonSaines
												, "speIntraInfect" => $speIntraInfect, "speInjectInfect" => $speInjectInfect, "obtTrayonInfect" => $obtTrayonInfect);
			$GLOBALS["TSFE"]->fe_user->setAndSaveSessionData("tabRepForm", $tabVarSession);
			//Redirection vers la page suivante
			$this->redirect("situationVaches");
		}
	}
	
	
	/**
   * Affichage de la seconde étape + réinitialisation du tableau de SESSION
   * contenant le listing des vaches
   *
   * @return void
   */ 
	public function situationVachesAction() {
		//On récupère la liste de vaches
		$tabVaches = $GLOBALS["TSFE"]->fe_user->getSessionData("tabVaches");
		
		$tabVachesAffich = array();
		
		foreach($tabVaches as $nomVache => $caracVache) {
			$maVache = t3lib_div::makeInstance('Tx_Tarissement_Vache');
			$maVache->setNomVache($nomVache);
			foreach($caracVache as $nomCarac => $valueCarac) {
				$maVache->setCarac($nomCarac, $valueCarac);
			}
			$tabVachesAffich[] = $maVache;
		}
		
		if(count($tabVachesAffich) != 0) {
			$isVaches = false;
		} else {
			$isVaches = true;
		}
		
		//On construit le tableau pour l'affichage
		$this->view->assign("listVaches", $tabVachesAffich);
		$this->view->assign("isVaches", $isVaches);
		
	}
	
	
	/**
   * Affichage de la troisième étape
   *
   * @return void
   */
	public function pratiquesTarissementAction() {
	
		$tabVarSession = $GLOBALS["TSFE"]->fe_user->getSessionData("tabRepForm");
			
		if(!empty($tabVarSession)) {
			$tx_tarissement_enBatiment = $tabVarSession["tx_tarissement_enBatiment"];
			$tx_tarissement_surfaceCouchage = $tabVarSession["tx_tarissement_surfaceCouchage"];
			$tx_tarissement_hygieneQuotidienne = $tabVarSession["tx_tarissement_hygieneQuotidienne"];
			$tx_tarissement_ventilationBatiment = $tabVarSession["tx_tarissement_ventilationBatiment"];
			
			$tx_tarissement_exercisePhysique = $tabVarSession["tx_tarissement_exercisePhysique"];
			$tx_tarissement_sortentPaturage = $tabVarSession["tx_tarissement_sortentPaturage"];
			$tx_tarissement_couchageARisque = $tabVarSession["tx_tarissement_couchageARisque"];
			$tx_tarissement_reintegrationTroupeau = $tabVarSession["tx_tarissement_reintegrationTroupeau"];
		} else {
			$tx_tarissement_enBatiment = $tx_tarissement_surfaceCouchage = $tx_tarissement_hygieneQuotidienne = $tx_tarissement_ventilationBatiment = "";
			$tx_tarissement_exercisePhysique = $tx_tarissement_sortentPaturage = $tx_tarissement_couchageARisque = $tx_tarissement_reintegrationTroupeau = "";
		}
		
		if($tx_tarissement_enBatiment == "oui") {
			$this->view->assign("tx_tarissement_enBatiment", 'true');
		} else {
			$this->view->assign("tx_tarissement_enBatiment", 'false');
		}
		if($tx_tarissement_surfaceCouchage == "oui") {
			$this->view->assign("tx_tarissement_surfaceCouchage", 'true');
		} else {
			$this->view->assign("tx_tarissement_surfaceCouchage", 'false');
		}
		if($tx_tarissement_hygieneQuotidienne == "oui") {
			$this->view->assign("tx_tarissement_hygieneQuotidienne", 'true');
		} else {
			$this->view->assign("tx_tarissement_hygieneQuotidienne", 'false');
		}
		if($tx_tarissement_ventilationBatiment == "oui") {
			$this->view->assign("tx_tarissement_ventilationBatiment", 'true');
		} else {
			$this->view->assign("tx_tarissement_ventilationBatiment", 'false');
		}
		if($tx_tarissement_exercisePhysique == "oui") {
			$this->view->assign("tx_tarissement_exercisePhysique", 'true');
		} else {
			$this->view->assign("tx_tarissement_exercisePhysique", 'false');
		}
		if($tx_tarissement_sortentPaturage == "oui") {
			$this->view->assign("tx_tarissement_sortentPaturage", 'true');
		} else {
			$this->view->assign("tx_tarissement_sortentPaturage", 'false');
		}
		if($tx_tarissement_couchageARisque == "oui") {
			$this->view->assign("tx_tarissement_couchageARisque", 'true');
		} else {
			$this->view->assign("tx_tarissement_couchageARisque", 'false');
		}
		if($tx_tarissement_reintegrationTroupeau == "oui") {
			$this->view->assign("tx_tarissement_reintegrationTroupeau", 'true');
		} else {
			$this->view->assign("tx_tarissement_reintegrationTroupeau", 'false');
		}
	
	
	}
	
	/**
   * Traitement du formulaire de la page PratiqueTarissement
   *
   * @param  string $tx_tarissement_enBatiment 
   * @param  string $tx_tarissement_surfaceCouchage 
   * @param  string $tx_tarissement_hygieneQuotidienne 
   * @param  string $tx_tarissement_ventilationBatiment 
   * @param  string $tx_tarissement_exercisePhysique 
   * @param  string $tx_tarissement_sortentPaturage 
   * @param  string $tx_tarissement_couchageARisque 
   * @param  string $tx_tarissement_reintegrationTroupeau 
   *
   * @return void   redirect to the propositionsTraitement
   */ 
	public function pratiquesTarissementFormAction($tx_tarissement_enBatiment, $tx_tarissement_surfaceCouchage, $tx_tarissement_hygieneQuotidienne, $tx_tarissement_ventilationBatiment, 
																			$tx_tarissement_exercisePhysique, $tx_tarissement_sortentPaturage, $tx_tarissement_couchageARisque, $tx_tarissement_reintegrationTroupeau) {
		
		//Traiter les réponses du formulaire pour les enregistrer en SESSION
		$tabVarSession = $GLOBALS["TSFE"]->fe_user->getSessionData("tabRepForm");
		$tabVarSession["tx_tarissement_enBatiment"] = $tx_tarissement_enBatiment;
		$tabVarSession["tx_tarissement_surfaceCouchage"] = $tx_tarissement_surfaceCouchage;
		$tabVarSession["tx_tarissement_hygieneQuotidienne"] = $tx_tarissement_hygieneQuotidienne;
		$tabVarSession["tx_tarissement_ventilationBatiment"] = $tx_tarissement_ventilationBatiment;
		$tabVarSession["tx_tarissement_exercisePhysique"] = $tx_tarissement_exercisePhysique;
		$tabVarSession["tx_tarissement_sortentPaturage"] = $tx_tarissement_sortentPaturage;
		$tabVarSession["tx_tarissement_couchageARisque"] = $tx_tarissement_couchageARisque;
		$tabVarSession["tx_tarissement_reintegrationTroupeau"] = $tx_tarissement_reintegrationTroupeau;
		$GLOBALS["TSFE"]->fe_user->setAndSaveSessionData("tabRepForm", $tabVarSession);
		
		//Redirection à l'étape suivante
		$this->redirect("propositionsTraitement");
	}
	
	/**
   * Affichage de la dernière étape + Traitement final
   *
   * @return void   
   */
	public function propositionsTraitementAction() {
		//On récupère les variables de SESSION
		$tabVaches = $GLOBALS["TSFE"]->fe_user->getSessionData("tabVaches");
		$tabRepForm = $GLOBALS["TSFE"]->fe_user->getSessionData("tabRepForm");
		
		//Separation des Vaches en 4 chaines pour les différents traitements
		$vachesTraitement1 = ""; 	// AB
		$vachesTraitement2 = "";	// AB + Obt
		$vachesTraitement3 = "";	// Obt seul
		$vachesTraitement4 = "";	// Rien ou Obt
		
		foreach($tabVaches as $nomVache => $tabCarac) {
			if($this->isSaine($tabCarac['CCI'], $tabRepForm['niveauTraitement']) == true) {
				if($this->niveauRisque($nomVache) == "eleve") {
					$vachesTraitement3 .= $nomVache.", ";
				} elseif($this->niveauRisque($nomVache) == "faible") {
					$vachesTraitement4 .= $nomVache.", ";
				} else {
					$vachesTraitement4 .= $nomVache.", ";
				}
			} else {
				if($this->niveauRisque($nomVache) == "eleve") {
					$vachesTraitement2 .= $nomVache.", ";
				} elseif($this->niveauRisque($nomVache) == "faible") {
					$vachesTraitement1 .= $nomVache.", ";
				} else {
					$vachesTraitement2 .= $nomVache.", ";
				}
			}
		}
		
		$vachesTraitement1 = substr($vachesTraitement1, 0, -2);
		if(empty($vachesTraitement1)) {
			$vachesTraitement1 = "Aucune";
		}
		$vachesTraitement2 = substr($vachesTraitement2, 0, -2);
		if(empty($vachesTraitement2)) {
			$vachesTraitement2 = "Aucune";
		}
		$vachesTraitement3 = substr($vachesTraitement3, 0, -2);
		if(empty($vachesTraitement3)) {
			$vachesTraitement3 = "Aucune";
		}
		$vachesTraitement4 = substr($vachesTraitement4, 0, -2);
		if(empty($vachesTraitement4)) {
			$vachesTraitement4 = "Aucune";
		}
		
		$this->view->assign("listVachesTraitement1", $vachesTraitement1);
		$this->view->assign("listVachesTraitement2", $vachesTraitement2);
		$this->view->assign("listVachesTraitement3", $vachesTraitement3);
		$this->view->assign("listVachesTraitement4", $vachesTraitement4);
		
	}
	
	/**
	* Determine si une vache est saine suivant le niveau d'exigence et le CCI de la vache
	*
	* @param  string $tauxCCI
	* @param  string $exigence 
	*
	* @return boolean
	*/ 
	public function isSaine($tauxCCI, $exigence) {
		
		if($exigence == "haut") {
			if($tauxCCI > 150000) {
				$etat = false;
			} elseif($tauxCCI > 100000) {
				$etat = false;
			} elseif($tauxCCI <= 100000) {
				$etat = true;
			}
		} else {
			if($tauxCCI > 150000) {
				$etat = true;
			} elseif($tauxCCI > 100000) {
				$etat = false;
			} elseif($tauxCCI <= 100000) {
				$etat = true;
			}
		}
		return $etat;
	}
	
	/**
	* Détermine le niveau de risque (élevé, faible, faible +Q9) de l'animal à partir des réponses au questions
	* Q3, Q4 Q5, Q6, Q7, Q8, Q10, Q11, Q12 et Q13 -- 1 point par question positive
	*
	* @param  string $nomVache
	*
	* @return string
	*/ 
	public function niveauRisque($nomVache) {
		
		$risqueForm = $this->comptabilisationFacteurRisqueForm(); 
		$risqueVache = $this->comptabilisationFacteurRisqueVaches($nomVache); 
		$totalRisque = $risqueForm + $risqueVache;
		
		if($totalRisque>2) {
			$niveauRisque = "eleve";
		} elseif($totalRisque>=1) {
			$niveauRisque = "faible";
		} else {
			$niveauRisque = "faible + Q9";
		}
		
		return $niveauRisque;
	}
	
	
	
	/**
   * Comptabilisation des facteurs de risque suivant les réponses aux questionnaires
   *
   * @param  array $tabRepForm 
   *
   * @return int
   */ 
	public function comptabilisationFacteurRisqueForm($tabRepForm) {
		$questionsRisque = array("tx_tarissement_surfaceCouchage", "tx_tarissement_hygieneQuotidienne", "tx_tarissement_ventilationBatiment", "tx_tarissement_exercisePhysique");
		
		$compteRisque = 0;
		foreach($tabRepForm as $question => $reponse) {
			if($reponse == "oui" && in_array($question, $questionsRisque)) {
				$compteRisque++;
			}
		}
		return $compteRisque;
	}
	
	/**
   * Comptabilisation du facteur de risque pour la vache concernée
   *
   * @param  array $tabVaches 
   *
   * @return int
   */ 
	public function comptabilisationFacteurRisqueVaches($nomVache) {
		$nomCaracRisque = array("troisiemeLactation", "plancherMamelle", "presencePlaies", "lesionsTrayon", "pertesLait", "trayonsCourts");
		$tabVaches = $GLOBALS["TSFE"]->fe_user->getSessionData("tabVaches");
		$tabCarac = $tabVaches[$nomVache];
		
		$compteRisque = 0;
		foreach($tabCarac as $nomCarac => $valueCarac) {
			if($valueCarac == "oui" && in_array($nomCarac, $nomCaracRisque)) {
				$compteRisque++;
			}
		}
		
		return $compteRisque;
	}
	
	
}




