$( document ).ready(function() {
	

	/* SITUATION TROUPEAU
	*********************************************************/
	var element = $("#tx_tarissement_etape1");
	if(element.length){
		
		$(".tx_tarissement_btn_valider").click(function() {
			var validation = true;
			
			//Controle de la première réponse
			if(!checkValididtyInput("#tx_tarissement_pourcentageCCI", "tx_tarissement_errorField")) { validation=false; }
			
			//Controle de la deuxième réponse
			if(!checkValididtyRadio("#resultatTraitementOui", ".resultatTraitementLabel", 'tx_tarissement_errorLabel')) { validation=false;  }
			
			//Controle de la troisième réponse
			if(!checkValididtyRadio("#triLait", ".triLaitLabel", 'tx_tarissement_errorLabel')) { validation=false;  }
			
			//Controle de la quatrième réponse
			if ($('#niveauTraitementHaut').prop('checked') == false && $('#niveauTraitementMoyen').prop('checked') == false) {
				$('.niveauTraitementLabel').addClass('tx_tarissement_errorLabel');
				validation = false;
			} else {
				$('.niveauTraitementLabel').removeClass('tx_tarissement_errorLabel');
			}

			// Suivant le remplissage des champs, on décide de la suite
			if(!validation) {
				alert('Attention, vous devez remplir/cocher l\'ensemble des champs');
			} else {
				$("#tx_tarissement_situationTroupeauForm").submit();
			}
		});
		
	}
	
	/* SITUATION VACHE
	*********************************************************/
	var element = $("#tx_tarissement_etape2");
	if(element.length){
	
		//Au clic sur le bouton Ajouter
		$("#tx_tarissement_ajoutVache").click(function() {
			ajoutVache();
		});
		
		//Au clic sur le bouton Modifier
		$("#tx_tarissement_modifVache").click(function() {
			modifVache();
		});
		
		//Au clic sur le bouton Suite
		$("#tx_tarissement_btn_suite").click(function() {
			$("#tx_tarissement_situationVachesForm").submit();
		});
	}
	
	
	/* PRATIQUE TARISSEMENT
	*********************************************************/
	var element = $("#tx_tarissement_etape3");
	if(element.length){
		
		if ($('#tx_tarissement_enBatimentOui').prop('checked') == true) {
			$('#tx_tarissement_OuiEnBatiment').show();
		}
		
		if ($('#tx_tarissement_sortentPaturageOui').prop('checked') == true) {
			$('#tx_tarissement_OuiAuPaturage').show();
		}

		
		$('input[type=radio][name="tx_tarissement_tarissementfront[tx_tarissement_enBatiment]"]').change(function() {
			if (this.value == 'oui') {
				$('#tx_tarissement_OuiEnBatiment').show();
			} else if (this.value == 'non') {
				$('#tx_tarissement_OuiEnBatiment').hide();
			}
		});
		
		// Si l'utilisateur coche oui à la seconde question
		$('input[type=radio][name="tx_tarissement_tarissementfront[tx_tarissement_sortentPaturage]"]').change(function() {
			if (this.value == 'oui') {
				$('#tx_tarissement_OuiAuPaturage').show();
			} else if (this.value == 'non') {
				$('#tx_tarissement_OuiAuPaturage').hide();
			}
		});
		
		
		
		$("#tx_tarissement_btn_suite").click(function() {
			var validation = true;
			
			//On verifie le remplissage des champs
			if(!checkValididtyRadio("#tx_tarissement_enBatiment", ".tx_tarissement_enBatiment", 'tx_tarissement_errorLabel')) { validation=false;  }
			
			if($('input[type=radio][name="tx_tarissement_tarissementfront[tx_tarissement_enBatiment]"]:checked').attr('value') == "oui") {
				if(!checkValididtyRadio("#tx_tarissement_surfaceCouchage", ".tx_tarissement_surfaceCouchage", 'tx_tarissement_errorLabel')) { validation=false;  }
				if(!checkValididtyRadio("#tx_tarissement_hygieneQuotidienne", ".tx_tarissement_hygieneQuotidienne", 'tx_tarissement_errorLabel')) { validation=false;  }
				if(!checkValididtyRadio("#tx_tarissement_ventilationBatiment", ".tx_tarissement_ventilationBatiment", 'tx_tarissement_errorLabel')) { validation=false;  }
				if(!checkValididtyRadio("#tx_tarissement_exercisePhysique", ".tx_tarissement_exercisePhysique", 'tx_tarissement_errorLabel')) { validation=false;  }
			}
			if(!checkValididtyRadio("#tx_tarissement_sortentPaturage", ".tx_tarissement_sortentPaturage", 'tx_tarissement_errorLabel')) { validation=false;  }
			if($('input[type=radio][name="tx_tarissement_tarissementfront[tx_tarissement_sortentPaturage]"]:checked').attr('value') == "oui") {
				if(!checkValididtyRadio("#tx_tarissement_couchageARisque", ".tx_tarissement_couchageARisque", 'tx_tarissement_errorLabel')) { validation=false;  }
			}
			if(!checkValididtyRadio("#tx_tarissement_reintegrationTroupeau", ".tx_tarissement_reintegrationTroupeau", 'tx_tarissement_errorLabel')) { validation=false;  }
			
			//Une fois les champs vérifié, on redirige ou on affiche un message
			if(!validation) {
				alert('Attention, vous devez remplir/cocher l\'ensemble des champs');
			} else {
				$("#tx_tarissement_pratiquesTarissementForm").submit();
			}
		});
	}
	
	
	//Au survol des infosbulles
	$(".tx_tarissement_help").hover(function() {
		$(this).next().show();
	},
	function() {
		$(this).next().hide();
	});
	
	
	
	
	
});


/* Ajout d'une vache dans le tableau de la page SITUATION VACHE
*************************************************************************/
function ajoutVache() {
	var validation = true;
	//On commence par controller les champs des formulaire
		
	if(!checkValididtyInput("#tx_tarissement_nomVache", "tx_tarissement_errorField")) { validation=false; }
	if(!checkValididtyInput("#tx_tarissement_CCI", "tx_tarissement_errorField")) { validation=false; }
	
	if(!checkValididtyRadio("#tx_tarissement_mammiteClinique", ".tx_tarissement_mammiteClinique", 'tx_tarissement_errorLabel')) { validation=false;  }
	if(!checkValididtyRadio("#tx_tarissement_troisiemeLactation", ".tx_tarissement_troisiemeLactation", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_plancherMamelle", ".tx_tarissement_plancherMamelle", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_presencePlaies", ".tx_tarissement_presencePlaies", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_lesionsTrayon", ".tx_tarissement_lesionsTrayon", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_pertesLait", ".tx_tarissement_pertesLait", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_trayonsCourts", ".tx_tarissement_trayonsCourts", 'tx_tarissement_errorLabel')) { validation=false; }
		
	
	if(validation) {
		//alert('validation du formulaire');
	
		// Fonction AJAX
		$.post( "?id=2&type=54169853&tx_tarissement_tarissementfront[action]=ajoutVache&tx_tarissement_tarissementfront[controller]=Ajax", 
		{
			typeAction: "ajout",
			nomVache: $('#tx_tarissement_nomVache').val(),
			CCI: $('#tx_tarissement_CCI').val(),
			mammiteClinique: $('input[type=radio][name="tx_tarissement_tarissementfront[mammiteClinique]"]:checked').attr('value'),
			troisiemeLactation: $('input[type=radio][name="tx_tarissement_tarissementfront[troisiemeLactation]"]:checked').attr('value'),
			plancherMamelle: $('input[type=radio][name="tx_tarissement_tarissementfront[plancherMamelle]"]:checked').attr('value'),
			presencePlaies: $('input[type=radio][name="tx_tarissement_tarissementfront[presencePlaies]"]:checked').attr('value'),
			lesionsTrayon: $('input[type=radio][name="tx_tarissement_tarissementfront[lesionsTrayon]"]:checked').attr('value'),
			pertesLait: $('input[type=radio][name="tx_tarissement_tarissementfront[pertesLait]"]:checked').attr('value'),
			trayonsCourts: $('input[type=radio][name="tx_tarissement_tarissementfront[trayonsCourts]"]:checked').attr('value'),
		}, function( data ) {
			if($(".tx_tarissement_novache").length){
				$(".tx_tarissement_novache").remove();
			}
			$(".tx_tarissement_ligne1").after(data);
		},
		"text"
		);
	} else {
		alert('Attention, vous devez remplir/cocher l\'ensemble des champs');
	}
}


/* Suppresion d'une vache dans le tableau de la page SITUATION VACHE
*************************************************************************/
function suppVache(nomVache) {
	//On supprime la ligne dans le tableau de SESSION
	$.post( "?id=2&type=54169853&tx_tarissement_tarissementfront[action]=suppVache&tx_tarissement_tarissementfront[controller]=Ajax", 
	{
		nomVache: nomVache
	}, function( data ) {
		$("#vache"+nomVache).remove(); // Puis on supprime la ligne dans l'affichage
		if(data!='') {
			$(".tx_tarissement_ligne1").after(data);
		}
	},
	"text"
	);
}


/* Recuperation des donées d'une vache pour modification
*************************************************************************/
function recupVacheForModif(nomVache) {
		
	$.post( "?id=2&type=54169853&tx_tarissement_tarissementfront[action]=recupVache&tx_tarissement_tarissementfront[controller]=Ajax", 
	{
		nomVache: nomVache,
	}, function( data ) {
		//alert("Nom vache : "+data);
		
		//Traitement des données récupérer pour les mettre dans les champs
		var reg=new RegExp("###");
		var tabInfosVaches = data.split(reg);
		
		$("#tx_tarissement_nomVache").val(tabInfosVaches[0]);
		$("#tx_tarissement_ancienNomVache").val(tabInfosVaches[0]);
		$("#tx_tarissement_CCI").val(tabInfosVaches[1]);
		changeCheck("#tx_tarissement_mammiteClinique", tabInfosVaches[2]);  //tx_tarissement_mammiteCliniqueOui
		changeCheck("#tx_tarissement_troisiemeLactation", tabInfosVaches[3]);
		changeCheck("#tx_tarissement_plancherMamelle", tabInfosVaches[4]);
		changeCheck("#tx_tarissement_presencePlaies", tabInfosVaches[5]);
		changeCheck("#tx_tarissement_lesionsTrayon", tabInfosVaches[6]);
		changeCheck("#tx_tarissement_pertesLait", tabInfosVaches[7]);
		changeCheck("#tx_tarissement_trayonsCourts", tabInfosVaches[8]);
		
		$('#tx_tarissement_titreFormVache').html('Modification d\'une vache');
		$('#tx_tarissement_ajoutVache').hide();
		$('#tx_tarissement_modifVache').show();
	},
	"text"
	);
	
}

/* Check un radio Oui/Non
*************************************************************************/
function changeCheck(id, value) {
	if(value == "oui") {
			$(id+"Oui").prop('checked', true);
		} else {
			$(id+"Non").prop('checked', true);
		}
}


/* Modification d'une vache dans le tableau de la page SITUATION VACHE
*************************************************************************/
function modifVache() {
	
	var validation = true;
	//On commence par controller les champs des formulaire
		
	if(!checkValididtyInput("#tx_tarissement_nomVache", "tx_tarissement_errorField")) { validation=false; }
	if(!checkValididtyInput("#tx_tarissement_CCI", "tx_tarissement_errorField")) { validation=false; }
	
	if(!checkValididtyRadio("#tx_tarissement_mammiteClinique", ".tx_tarissement_mammiteClinique", 'tx_tarissement_errorLabel')) { validation=false;  }
	if(!checkValididtyRadio("#tx_tarissement_troisiemeLactation", ".tx_tarissement_troisiemeLactation", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_plancherMamelle", ".tx_tarissement_plancherMamelle", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_presencePlaies", ".tx_tarissement_presencePlaies", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_lesionsTrayon", ".tx_tarissement_lesionsTrayon", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_pertesLait", ".tx_tarissement_pertesLait", 'tx_tarissement_errorLabel')) { validation=false; }
	if(!checkValididtyRadio("#tx_tarissement_trayonsCourts", ".tx_tarissement_trayonsCourts", 'tx_tarissement_errorLabel')) { validation=false; }
	
	if(validation) {
		//On supprime la ligne dans le tableau de SESSION
		$.post( "?id=2&type=54169853&tx_tarissement_tarissementfront[action]=modifVache", 
		{
			ancienNomVache: $('#tx_tarissement_ancienNomVache').val(),
			nomVache: $('#tx_tarissement_nomVache').val(),
			CCI: $('#tx_tarissement_CCI').val(),
			mammiteClinique: $('input[type=radio][name="tx_tarissement_tarissementfront[mammiteClinique]"]:checked').attr('value'),
			troisiemeLactation: $('input[type=radio][name="tx_tarissement_tarissementfront[troisiemeLactation]"]:checked').attr('value'),
			plancherMamelle: $('input[type=radio][name="tx_tarissement_tarissementfront[plancherMamelle]"]:checked').attr('value'),
			presencePlaies: $('input[type=radio][name="tx_tarissement_tarissementfront[presencePlaies]"]:checked').attr('value'),
			lesionsTrayon: $('input[type=radio][name="tx_tarissement_tarissementfront[lesionsTrayon]"]:checked').attr('value'),
			pertesLait: $('input[type=radio][name="tx_tarissement_tarissementfront[pertesLait]"]:checked').attr('value'),
			trayonsCourts: $('input[type=radio][name="tx_tarissement_tarissementfront[pertesLait]"]:checked').attr('value'),
		}, function( data ) {
			nomVache = $('#tx_tarissement_ancienNomVache').val();
			$("#vache"+nomVache).replaceWith(data); // Puis on supprime la ligne dans l'affichage
		},
		"text"
		);
	} else {
		alert('Attention, vous devez remplir/cocher l\'ensemble des champs');
	}
}


/* Verification du remplissage d'un input text
*************************************************************************/
function checkValididtyInput(idInput, classAdd = "tx_tarissement_errorField") {
	if($(idInput).val() == "") {
		$(idInput).addClass(classAdd);
		return false;
	} else {
		$(idInput).removeClass(classAdd);
		return true;
	}
}


/* Verification du remplissage d'un input radio
*************************************************************************/
function checkValididtyRadio(idRadio, classLabel, classAdd = 'tx_tarissement_errorLabel') {
	if ($(idRadio+'Oui').prop('checked') == false && $(idRadio+'Non').prop('checked') == false) {
		$(classLabel).addClass(classAdd);
		return false;
	} else {
		$(classLabel).removeClass(classAdd);
		return true;
	}
}
