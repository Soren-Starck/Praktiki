<link rel="stylesheet" href="assets/css/maj.css">

<?php
$num = htmlspecialchars($user->getNumEtudiant());
$nom = htmlspecialchars($user->getNomEtudiant());
$prenom = htmlspecialchars($user->getPrenomEtudiant());
$mailPerso = htmlspecialchars($user->getMailPersoEtudiant());
$mailUniv = htmlspecialchars($user->getMailUniversitaireEtudiant());
$Telephone = htmlspecialchars($user->getTelephoneEtudiant());
$codePostal = htmlspecialchars($user->getCodePostalEtudiant());
?>


    <div class="containerInfo">
    <form method="post" action="frontController.php?action=displayTDB&controller=TDB&tdbAction=MettreAJour">
        <h2 id="remplaceBaliseLegend">Généralités</h2>

        <div class="column">
            <p>
                <label class="InputAddOn-item" for="num">Numéro Etudiant :</label>
                <input class="InputAddOn-field" type="text" value=<?= $num ?> name="num" id="num" readonly>
                <label class="InputAddOn-item" for="nom">Nom :</label>
                <input class="InputAddOn-field" type="text" value=<?= $nom ?> name="nom" id="nom" readonly/>
                <label class="InputAddOn-item" for="prenom">Prenom : </label>
                <input class="InputAddOn-field" type="text" value=<?= $prenom ?> name="prenom" id="prenom" readonly>
                <label class="InputAddOn-item" for="telephone">Telephone :</label>
                <input class="InputAddOn-field" type="text" value=<?= $Telephone ?> name="telephone" id="telephone" required>
   
            </p>
        </div>

        <div class="column">
            <p>
                <label class="InputAddOn-item" for="postcode">Code Postal :</label>
                <input class="InputAddOn-field" type="text" value=<?= $codePostal ?> name="postcode" id="postcode" required>
                <label class="InputAddOn-item" for="mailUniv">Email Universitaire :</label>
                <input class="InputAddOn-field" type="text" value=<?= $mailUniv ?> name="mailUniv" id="mailUniv" readonly>
                <label class="InputAddOn-item" for="mailPerso">Email Personnel :</label>
                <input class="InputAddOn-field" type="text" value=<?= $mailPerso ?> name="mailPerso" id="mailPerso" required>

            </p>
        </div>
        <input type="submit" value="Mettre à jour">
    </form>
</div>










