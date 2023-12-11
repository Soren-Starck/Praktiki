<?php
namespace App\SAE\Controller;
use App\SAE\Lib\ConnexionUtilisateur;
use App\SAE\Model\DataObject\AbstractDataObject;
use App\SAE\Model\DataObject\Etudiant;
use App\SAE\Model\Repository\AbstractExperienceProfessionnelRepository;
use App\SAE\Model\Repository\AbstractRepository;
use App\SAE\Model\Repository\EtudiantRepository;
use App\SAE\Model\Repository\ExperienceProfessionnelRepository;
use App\SAE\Model\Repository\Model;

class ControllerEtudiant extends ControllerGenerique{

    public static function afficherListeEtudiant(){
        self::afficheVue("view.php", [
            "pagetitle" => "Liste des étudiants",
            "cheminVueBody" => "student/studentList.php"
        ]);
    }

    public static function getEtudiantBySearch(): void
    {
        $keywords = "";
        if(isset($_GET['keywords'])){
            $keywords = urldecode($_GET["keywords"]);
        }
        $listEtudiants = (new EtudiantRepository())->getAll();
        self::afficheVue(
            'view.php',
            [
                'pagetitle' => 'Recherche',
                'listEtudiants' => $listEtudiants,
                'cheminVueBody' => 'student/studentList.php',
            ]
        );
    }

    public static function getNbEtudiantExpProValide(): int
    {
        $nbEtudiantExpProValidee = 0;
        $listEtudiants = (new EtudiantRepository())->getAll();
        foreach ($listEtudiants as $etudiant) {
            if ((new EtudiantRepository())->conventionEtudiantEstValide($etudiant)) {
                $nbEtudiantExpProValidee++;
            }
        }
        return $nbEtudiantExpProValidee;
    }

    public static function getNbEtudiantExpProValideSansConvention(): int
    {
        $nbEtudiantExpProValideeSansConvention = 0;
        $listEtudiants = (new EtudiantRepository())->getAll();
        foreach ($listEtudiants as $etudiant) {
            if ((new EtudiantRepository())->conventionEtudiantEstValide($etudiant) && !(new EtudiantRepository())->etudiantAStage($etudiant) && !(new EtudiantRepository())->etudiantAAlternance($etudiant)) {
                $nbEtudiantExpProValideeSansConvention++;
            }
        }
        return $nbEtudiantExpProValideeSansConvention;
    }

    public static function getNbEtudiantExpProNonValide(): int
    {
        $nbEtudiantExpProNonValidee = 0;
        $listEtudiants = (new EtudiantRepository())->getAll();
        foreach ($listEtudiants as $etudiant) {
            if (!(new EtudiantRepository())->conventionEtudiantEstValide($etudiant)) {
                $nbEtudiantExpProNonValidee++;
            }
        }
        return $nbEtudiantExpProNonValidee;
    }

}