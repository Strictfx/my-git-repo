<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Tarissementfront',
	array(
		'Tarissementfront' => 'situationTroupeau, situationTroupeauForm, situationVaches, pratiquesTarissement, pratiquesTarissementForm, propositionsTraitement',
		'Ajax' => 'ajoutVache, suppVache, modifVache, recupVache',
		
	),
	// non-cacheable actions
	array(
		'Tarissementfront' => 'situationTroupeau, situationTroupeauForm, situationVaches, pratiquesTarissement, pratiquesTarissementForm, propositionsTraitement',
		'Ajax' => 'ajoutVache, suppVache, modifVache, recupVache',
	)
);

?>