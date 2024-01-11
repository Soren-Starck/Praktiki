<?php
$expPro = $experiencePro;
$typeExperience = 'alternance';
if (is_a($expPro, 'App\SAE\Model\DataObject\Stage')) { // Si c'est un stage
    $typeExperience = 'stage';
    $gratification = $expPro->getGratificationStage();
} else {//si c'est une offre non défini
    $typeExperience = 'offreNonDefini';
}
?>
<link rel="stylesheet" href="assets/css/connect.css">
<script src="assets/javascript/showHideToggle.js"></script>

<div class="container">
    <form method="post" action="frontController.php?controller=ExpPro&action=modifierDepuisFormulaire">

        <?php if(\App\SAE\Lib\ConnexionUtilisateur::estAdministrateur() || \App\SAE\Lib\ConnexionUtilisateur::estEnseignant()){ ?>
        <p>
            <label for="commentaireProfesseur">Commentaire Professeur</label>
            <textarea name="commentaireProfesseur" id="commentaireProfesseur" cols="30" rows="10" maxlength="500"
                      placeholder="Commentaire Professeur"><?php echo htmlspecialchars($expPro->getCommentaireProfesseur()); ?></textarea>
        </p>
        <?php } ?>

        <p>
            <input type="hidden" name="id"
                   value="<?php echo htmlspecialchars($expPro->getIdExperienceProfessionnel()); ?>">
            <input type="submit" value="Modifier l'offre">
        </p>
