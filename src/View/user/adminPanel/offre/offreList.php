<div class="HBox">
    <div id="title"><div class="HBox"><img src="assets/images/etudiant-icon.png" alt="logo etudiant">Liste des Offres</div></div>
    <?php $action="panelListeOffres";
    $controller="PanelAdmin";
    require_once __DIR__ . '/../../../utilitaire/searchBar.php';?>
</div>

<div class="columnName">
    <div id="columnFirst" class="HBox containerDebutLine">
        <label>Type</label>
        <label class="lineSujetOffre">Sujet offre</label>
    </div>
    <label class="lineEntrepriseOffre">Entreprise</label>
    <label class="lineDateOffre">Date publication</label>
</div>

<div class="VBox">
    <?php
    foreach ($listOffres as $offre){
        require __DIR__."/offreLine.php";
    }
    ?>
</div>

<div id="popUpDelete" class="subContainer">
    <a id="popUpDeleteClose"><img src="assets/images/close-icon.png" id="closeIcon" alt="Close"></a>
    <div id="popUpDeleteContent">
        <p>Êtes-vous sûr de vouloir supprimer cette offre ?</p>
        <div class="HBox">
            <a class="button popUpDeleteButton" id="popUpDeleteNo">Non</a>
            <a class="button popUpDeleteButton" id="popUpDeleteYes" href="frontController.php?controller=ExpPro&action=supprimerOffre&experiencePro=<?php echo rawurlencode($expPro->getIdExperienceProfessionnel()) ?>">Oui</a>
        </div>
    </div>
</div>