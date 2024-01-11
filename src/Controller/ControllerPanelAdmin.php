<?php

namespace App\SAE\Controller;

use App\SAE\Lib\MessageFlash;
use App\SAE\Model\DataObject\Etudiant;
use App\SAE\Model\Repository\EntrepriseRepository;
use App\SAE\Model\Repository\EtudiantRepository;
use App\SAE\Model\Repository\ExperienceProfessionnelRepository;
use App\SAE\Service\ServiceEntreprise;
use App\SAE\Service\ServiceEtudiant;

class ControllerPanelAdmin extends ControllerGenerique {

    public static function panelEtudiants(): void {
        $listEtudiants = (new EtudiantRepository())->getAll();
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                'adminPanelView' => 'student/studentList.php',
                                                'listEtudiants' => $listEtudiants]);
    }

    public static function panelEntreprises(): void {
        $keywords = ControllerEntreprise::keywordsExiste();
        $codePostalEntreprise = ControllerEntreprise::codePostalExiste();
        $effectifEntreprise = ControllerEntreprise::effectifExiste();
        $listEntreprises = (new EntrepriseRepository)->getEntrepriseEnAttenteFiltree($keywords, $codePostalEntreprise, $effectifEntreprise);
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                'adminPanelView' => 'company/companyListWaiting.php',
                                                'listEntreprises' => $listEntreprises ]);
    }

    public static function panelOffres(): void {
        $keywords = ControllerExpPro::keywordsExiste();
        $dateDebut = ControllerExpPro::dateDebutExiste();
        $dateFin = ControllerExpPro::dateFinExiste();
        $typeContrat = ControllerExpPro::typeContratExiste();
        $niveauEtude = ControllerExpPro::niveauEtudeExiste();
        $codePostal = ControllerExpPro::codePostalExiste();
        $optionTri = ControllerExpPro::optionTriExiste();
        $listOffres = (new ExperienceProfessionnelRepository())->getExpProFiltree($keywords, $dateDebut, $dateFin, $typeContrat, $niveauEtude, $codePostal, $optionTri);
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                'adminPanelView' => 'offre/offerList.php',
                                                'listOffres' => $listOffres ]);
    }

    public static function panelImportPstage(): void{
        self::afficheVue('view.php', ['pagetitle' => 'Importation des données',
            'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
            'adminPanelView' => 'user/adminPanel/import/index.php']);
    }

    public static function panelListeEntreprises(): void {
        $keywords = "";
        if(isset($_GET["keywords"])){
            $keywords .= $_GET["keywords"];
        }
        $listEntreprises = (new EntrepriseRepository)->getEntrepriseAvecEtatFiltree(null,$keywords);
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                'adminPanelView' => 'user/adminPanel/entreprise/entrepriseList.php',
                                                'listEntreprises' => $listEntreprises,
                                                'keywords' => $keywords]);
    }

    public static function panelListeEtudiants(): void {
        $keywords = "";
        if(isset($_GET["keywords"])){
            $keywords .= $_GET["keywords"];
        }
        $listEtudiants = (new EtudiantRepository())->searchs($keywords);
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                'adminPanelView' => 'user/adminPanel/etudiant/etudiantList.php',
                                                'listEtudiants' => $listEtudiants ]);
    }

    public static function panelListeOffres(): void {
        $keywords = "";
        if(isset($_GET["keywords"])){
            $keywords .= $_GET["keywords"];
        }
        $listOffres = (new ExperienceProfessionnelRepository())->search($keywords);
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                'adminPanelView' => 'user/adminPanel/offre/offreList.php',
                                                'listOffres' => $listOffres ]);
    }

    public static function panelGestionEntreprise(): void {
        if(!isset($_GET["siret"])){
            self::error("Entreprise non défini");
            return;
        }
        $entreprise = (new EntrepriseRepository())->getById(rawurldecode($_GET["siret"]));
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                'adminPanelView' => 'user/adminPanel/entreprise/managementEntreprise.php',
                                                'entreprise' => $entreprise ]);
    }

    public static function validerEntreprise(): void{
        if(!isset($_GET["siret"])){
            self::error("Entreprise non défini");
            return;
        }
        $entreprise = (new EntrepriseRepository())->getById(rawurldecode($_GET["siret"]));
        $entreprise->setEstValide(true);
        (new EntrepriseRepository())->mettreAJour($entreprise);
        self::panelGestionEntreprise();
    }

    public static function invaliderEntreprise(): void{
        if(!isset($_GET["siret"])){
            self::error("Entreprise non défini");
            return;
        }
        $entreprise = (new EntrepriseRepository())->getById(rawurldecode($_GET["siret"]));
        $entreprise->setEstValide(false);
        (new EntrepriseRepository())->mettreAJour($entreprise);
        self::panelGestionEntreprise();
    }

    public static function supprimerEntreprise(): void{
        if(!isset($_GET["siret"])){
            self::error("Entreprise non défini");
            return;
        }
        (new EntrepriseRepository())->supprimer(rawurldecode($_GET["siret"]));
        self::panelListeEntreprises();
    }

    public static function panelModificationEntreprise(): void{
        if(!isset($_GET["siret"])){
            self::error("Entreprise non défini");
            return;
        }
        $entreprise = (new EntrepriseRepository())->getById(rawurldecode($_GET["siret"]));
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
            'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
            'adminPanelView' => 'user/adminPanel/entreprise/modificationEntreprise.php',
            'entreprise' => $entreprise ]);
    }

    public static function modifierEntreprise(): void{
        $attributs = [];
        if(!isset($_POST["siret"])){
            self::redirectionVersURL("warning", "aucun siret fourni, impossible d'identifier l'entreprise", "panelListeEntreprises&controller=PanelAdmin");
            return;
        }
        if(isset($_POST["nom"])){
            $attributs["nomEntreprise"] = $_POST["nom"];
        }
        if(isset($_POST["mail"])){
            $attributs["mailEntreprise"] = $_POST["mail"];
        }
        if(isset($_POST["telephone"])){
            $attributs["telephoneEntreprise"] = $_POST["telephone"];
        }
        if(isset($_POST["codePostal"])){
            $attributs["codePostalEntreprise"] = $_POST["codePostal"];
        }
        if(isset($_POST["website"])){
            $attributs["siteWebEntreprise"] = $_POST["website"];
        }
        if(isset($_POST["effectif"])){
            $attributs["effectifEntreprise"] = $_POST["effectif"];
        }
        $entreprise = (new EntrepriseRepository())->getById($_POST["siret"]);
        if($entreprise == null){
            self::redirectionVersURL("warning", "aucune entreprise ne correspond à ce siret", "panelListeEntreprises&controller=PanelAdmin");
            return;
        }
        (new ServiceEntreprise())->mettreAJour($entreprise, $attributs);
        self::panelGestionEntreprise();
    }

    public static function panelGestionEtudiant(): void {
        if(!isset($_GET["numEtudiant"])){
            self::error("Etudiant non défini");
            return;
        }
        $etudiant = (new EtudiantRepository())->getById(rawurldecode($_GET["numEtudiant"]));
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                                'adminPanelView' => 'user/adminPanel/etudiant/managementEtudiant.php',
                                                                'etudiant' => $etudiant ]);
    }

    public static function supprimerEtudiant(): void{
        if(!isset($_GET["numEtudiant"])){
            self::error("Etudiant non défini");
            return;
        }
        (new EtudiantRepository())->supprimer(rawurldecode($_GET["numEtudiant"]));
        self::panelListeEtudiants();
    }

    public static function panelModificationEtudiant(): void{
        if(!isset($_GET["numEtudiant"])){
            self::error("Etudiant non défini");
            return;
        }
        $etudiant = (new EtudiantRepository())->getById(rawurldecode($_GET["numEtudiant"]));
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
                                                                'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
                                                                'adminPanelView' => 'user/adminPanel/etudiant/modificationEtudiant.php',
                                                                'etudiant' => $etudiant ]);
    }

    public static function modifierEtudiant(): void{
        $attributs = [];
        if(!isset($_POST["numEtudiant"])){
            self::redirectionVersURL("warning", "aucun numEtudiant fourni, impossible d'identifier l'étudiant", "panelListeEtudiants&controller=PanelAdmin");
            return;
        }
        if(isset($_POST["mailPerso"])){
            $attributs["mailPersoEtudiant"] = $_POST["mailPerso"];
        }
        if(isset($_POST["telephone"])){
            $attributs["telephoneEtudiant"] = $_POST["telephone"];
        }
        if(isset($_POST["codePostal"])){
            $attributs["codePostalEtudiant"] = $_POST["codePostal"];
        }
        if(isset($_POST["nom"])){
            $attributs["nomEtudiant"] = $_POST["nom"];
        }
        if(isset($_POST["prenom"])){
            $attributs["prenomEtudiant"] = $_POST["prenom"];
        }
        if(isset($_POST["telephone"])){
            $attributs["telephoneEtudiant"] = $_POST["telephone"];
        }
        if(isset($_POST["mailUniv"])){
            $attributs["mailUniversitaireEtudidant"] = $_POST["mailUniv"];
        }
        $etudiant = (new EtudiantRepository())->getById($_POST["numEtudiant"]);
        if($etudiant == null){
            self::redirectionVersURL("warning", "aucun etudiant ne possède se numEtudiant", "panelListeEtudiants&controller=PanelAdmin");
        }
        (new ServiceEtudiant())->mettreAJour($etudiant, $attributs);
        self::panelGestionEtudiant();
    }

    public static function panelStatistique(){
        self::afficheVue('view.php', ['pagetitle' => 'Panel Administrateur',
            'cheminVueBody' => 'user/adminPanel/panelAdmin.php',
            'adminPanelView' => 'user/adminPanel/statistique/statistiques.php']);
    }

}