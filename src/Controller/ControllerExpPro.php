<?php

namespace App\SAE\Controller;

use App\SAE\Model\Repository\AlternanceRepository;
use App\SAE\Model\Repository\Model;
use App\SAE\Model\Repository\StageRepository;
use App\SAE\Model\Repository\ExperienceProfessionnelRepository;
use App\SAE\Model\DataObject\Stage;

class ControllerExpPro extends ControllerGenerique{
    public static function getExpProByDefault(): void
    {
        $listeExpPro = ExperienceProfessionnelRepository::search("");
        self::afficheVue(
            'view.php',
            [
                'pagetitle' => 'Offre',
                'listeExpPro' => $listeExpPro,
                'cheminVueBody' => 'offer/offerList.php',
            ]
        );
    }

    public static function getExpProBySearch(): void
    {
        $keywords = urldecode($_GET['keywords']);
        $listeExpPro = ExperienceProfessionnelRepository::search($keywords);
        self::afficheVue(
            'view.php',
            [
                'pagetitle' => 'Offre',
                'listeExpPro' => $listeExpPro,
                'cheminVueBody' => 'offer/offerList.php',
            ]
        );
    }

    public static function getExpProByFiltre(): void
    {
        $dateDebut = null;
        $dateFin = null;
        $optionTri = null;
        $stage = null;
        $alternance = null;
        $codePostal = null;
        $datePublication = null;
        if (isset($_GET['dateDebut'])){
            $dateDebut = $_GET['dateDebut'];
        }
        if (isset($_GET['dateFin'])){
            $dateFin = $_GET['dateFin'];
        }
        if (isset($_GET['optionTri'])){
            $optionTri = $_GET['optionTri'];
        }
        if (isset($_GET['stage'])){
            $stage = $_GET['stage'];
        }
        if (isset($_GET['alternance'])){
            $alternance = $_GET['alternance'];
        }
        if (isset($_GET['codePostal'])){
            $codePostal = $_GET['codePostal'];
        }
        if (isset($_GET['datePublication'])){
            $datePublication = $_GET['datePublication'];
        }
        $listeExpPro = ExperienceProfessionnelRepository::filtre($dateDebut, $dateFin, $optionTri, $stage, $alternance, $codePostal, $datePublication);
        self::afficheVue(
            'view.php',
            [
                'pagetitle' => 'Offre',
                'listeExpPro' => $listeExpPro,
                'cheminVueBody' => 'offer/offerList.php',
            ]
        );
    }

    public static function modifierDepuisFormulaire(): void
    {
        $msg = "Offre modifiée avec succés !";
        $tab = [
            "sujetExperienceProfessionnel" => $_POST["sujet"],
            "thematiqueExperienceProfessionnel" => $_POST["thematique"],
            "tachesExperienceProfessionnel" => $_POST["taches"],
            "codePostalExperienceProfessionnel" => $_POST["codePostal"],
            "adresseExperienceProfessionnel" => $_POST["adressePostale"],
            "dateDebutExperienceProfessionnel" => $_POST["dateDebut"],
            "dateFinExperienceProfessionnel" => $_POST["dateFin"],
            "siret" => $_POST["siret"]
        ];
        // Si c'est un stage
        if ($_POST["typeOffre"] == "stage") {
            $tab["gratificationStage"] = $_POST["gratification"]; // Un stage a une gratification à renseigner en plus
            $tab["idStage"] = $_POST["id"];
            $stage = StageRepository::construireDepuisTableau($tab);
            StageRepository::mettreAJour($stage);
            self::afficherVueEndOffer($msg); // Redirection vers une page
        } // Si c'est une alternance
        elseif ($_POST["typeOffre"] == "alternance") {
            $tab["idAlternance"] = $_POST["id"];
            $alternance = AlternanceRepository::construireDepuisTableau($tab);
            AlternanceRepository::mettreAJour($alternance);
            self::afficherVueEndOffer($msg); // Redirection vers une page
        } // Si c'est une stalternance
        elseif ($_POST["typeOffre"] == "stalternance"  || $_POST["typeOffre"] == "Non définie") {
                    $tab["idExpPro"] = $_POST["id"];
                    $stalternance = ExperienceProfessionnelRepository::construireDepuisTableau($tab);
                    ExperienceProfessionnelRepository::mettreAJour($stalternance);
                    self::afficherVueEndOffer($msg); // Redirection vers une page
                } // Si ce n'est aucun des 3 alors ce n'est pas normal
        else {
            ControllerGenerique::error("Ce type d'offre n'existe pas");
        }
    }

    public static function afficherVueEndOffer($msg): void
    {
        ControllerGenerique::afficheVue("view.php", [
            "pagetitle" => "Gestion d'offer",
            "cheminVueBody" => "offer/endOffer.php",
            "message" => $msg
        ]);
    }

    public static function afficherFormulaireModification(): void
    {
        $idExpPro = $_GET["experiencePro"];
        $pagetitle = 'Modification Offre';
        $cheminVueBody = 'offer/editOffer.php';

        $stage = StageRepository::get($idExpPro);


        // Si c'est un stage alors c'est good
        if (!is_null($stage)) {
            ControllerGenerique::afficheVue('view.php', [
                "pagetitle" => $pagetitle,
                "cheminVueBody" => $cheminVueBody,
                "experiencePro" => $stage
            ]);
        } // On vérifie que c'est une alternance sinon on affiche un message d'erreur
        else {
            // On vérifie que c'est une alternance
            $alternance = AlternanceRepository::get($idExpPro); //Dans un else pour éviter de faire 2 requêtes s'il n'y a pas besoin
            if (!is_null($alternance)) {
                ControllerGenerique::afficheVue('view.php', [
                    "pagetitle" => $pagetitle,
                    "cheminVueBody" => $cheminVueBody,
                    "experiencePro" => $alternance
                ]);
            } else {
                $stalternance = ExperienceProfessionnelRepository::get($idExpPro);
                if (!is_null($stalternance)) {
                    ControllerGenerique::afficheVue('view.php', [
                        "pagetitle" => $pagetitle,
                        "cheminVueBody" => $cheminVueBody,
                        "experiencePro" => $stalternance
                    ]);
                } else {
                    $messageErreur = 'Cette offre n existe pas !';
                    ControllerGenerique::error($messageErreur);
                }
            }
        }
    }

    public static function afficherOffre(): void
    {
        $idExpPro = $_GET["experiencePro"];

        $stage = StageRepository::get($idExpPro);

        if (!is_null($stage)) {
            ControllerGenerique::afficheVue('view.php', [
                "pagetitle" => "Affichage offer",
                "cheminVueBody" => "offer/offer.php",
                "expPro" => $stage
            ]);
        } else {
            $alternance = AlternanceRepository::get($idExpPro);
            if (!is_null($alternance)) {
                ControllerGenerique::afficheVue('view.php', [
                    "pagetitle" => "Affichage offer",
                    "cheminVueBody" => "offer/offer.php",
                    "expPro" => $alternance
                ]);
            } else {
                $stalternance = ExperienceProfessionnelRepository::get($idExpPro);
                if (!is_null($stalternance)) {
                    ControllerGenerique::afficheVue('view.php', [
                        "pagetitle" => "Affichage offer",
                        "cheminVueBody" => "offer/offer.php",
                        "expPro" => $stalternance
                    ]);
                } else {
                    $messageErreur = 'Cette offre n existe pas !';
                    ControllerGenerique::error($messageErreur);
                }
            }
        }
    }

    public static function creerOffreDepuisFormulaire(): void
    {
        $msg = "Offre crée avec succés !";
        if ($_POST["typeOffre"] == "stage") {
            $stage = StageRepository::construireDepuisTableau([
                "sujetExperienceProfessionnel" => $_POST["sujet"],
                "thematiqueExperienceProfessionnel" => $_POST["thematique"],
                "tachesExperienceProfessionnel" => $_POST["taches"],
                "codePostalExperienceProfessionnel" => $_POST["codePostal"],
                "adresseExperienceProfessionnel" => $_POST["adressePostale"],
                "dateDebutExperienceProfessionnel" => $_POST["dateDebut"],
                "dateFinExperienceProfessionnel" => $_POST["dateFin"],
                "siret" => $_POST["siret"],
                "gratificationStage" => $_POST["gratification"]
            ]);
            StageRepository::save($stage);
            self::afficherVueEndOffer($msg); // Redirection vers une page
        } else if ($_POST["typeOffre"] == "alternance") {
            $alternance = AlternanceRepository::construireDepuisTableau([
                "sujetExperienceProfessionnel" => $_POST["sujet"],
                "thematiqueExperienceProfessionnel" => $_POST["thematique"],
                "tachesExperienceProfessionnel" => $_POST["taches"],
                "codePostalExperienceProfessionnel" => $_POST["codePostal"],
                "adresseExperienceProfessionnel" => $_POST["adressePostale"],
                "dateDebutExperienceProfessionnel" => $_POST["dateDebut"],
                "dateFinExperienceProfessionnel" => $_POST["dateFin"],
                "siret" => $_POST["siret"]
            ]);
            AlternanceRepository::save($alternance);
            self::afficherVueEndOffer($msg); // Redirection vers une page
        } else if ($_POST["typeOffre"] == "stalternance" || $_POST["typeOffre"] == "Non définie") {
            $stalternance = ExperienceProfessionnelRepository::construireDepuisTableau([
                "sujetExperienceProfessionnel" => $_POST["sujet"],
                "thematiqueExperienceProfessionnel" => $_POST["thematique"],
                "tachesExperienceProfessionnel" => $_POST["taches"],
                "codePostalExperienceProfessionnel" => $_POST["codePostal"],
                "adresseExperienceProfessionnel" => $_POST["adressePostale"],
                "dateDebutExperienceProfessionnel" => $_POST["dateDebut"],
                "dateFinExperienceProfessionnel" => $_POST["dateFin"],
                "siret" => $_POST["siret"]
            ]);
            ExperienceProfessionnelRepository::save($stalternance);
            self::afficherVueEndOffer($msg); // Redirection vers une page
        } else {
            ControllerGenerique::error("Ce type d'offre n'existe pas");
        }
    }

    public static function supprimerOffre(): void {
        $idExpPro = $_GET["experiencePro"];
        $stage = StageRepository::get($idExpPro);

        // Si c'est un stage alors c'est good
        if (!is_null($stage)) {
            StageRepository::supprimer($stage);
            self::afficherVueEndOffer("Stage supprimée avec succès");
        } else {
            $alternance = AlternanceRepository::get($idExpPro); //Dans un else pour éviter de faire 2 requêtes s'il n'y a pas besoin
            if (!is_null($alternance)) {
                AlternanceRepository::supprimer($alternance);
                self::afficherVueEndOffer("Alternance supprimée avec succès");
            } else {
                $stalternance = ExperienceProfessionnelRepository::get($idExpPro);
                if (!is_null($stalternance)) {
                    ExperienceProfessionnelRepository::supprimer($stalternance);
                    self::afficherVueEndOffer("Stalternance supprimée avec succès");
                } else {
                    $messageErreur = 'Cette offre n existe pas !';
                    ControllerGenerique::error($messageErreur);
                }
            }
        }
    }

    public static function createOffer(): void
    {
        ControllerGenerique::afficheVue(
            'view.php',
            [
                'pagetitle' => 'Créer une offre',
                'cheminVueBody' => 'offer/createOffer.php',
            ]
        );
    }

    public static function displayOffer(): void
    {
        ControllerGenerique::afficheVue(
            'view.php',
            [
                'pagetitle' => 'Offre',
                'cheminVueBody' => 'offer/offerList.php',
            ]
        );
    }
}


