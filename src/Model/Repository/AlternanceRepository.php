<?php

namespace App\SAE\Model\Repository;

use App\SAE\Model\DataObject\AbstractDataObject;
use App\SAE\Model\DataObject\Alternance;
use App\SAE\Model\DataObject\ExperienceProfessionnel;

class AlternanceRepository extends AbstractExperienceProfessionnelRepository
{
    protected function getNomDataObject(): string
    {
        return "Alternance";
    }
    protected function getNomsColonnesSupplementaires(): array
    {
        return array("idAlternance");
    }

    protected function getNomClePrimaire(): string
    {
        return "idAlternance";
    }

    protected function getNomTable(): string
    {
        return "Alternances";
    }
    public function save(AbstractDataObject $a): bool
    {
        try {
            ExperienceProfessionnelRepository::save($a);
            $pdo = Model::getPdo();
            $requestStatement = $pdo->prepare("INSERT INTO Alternances(idAlternance)
                                                 VALUES(:idAlternanceTag)");
            $values = array("idAlternanceTag" => $pdo->lastInsertId());

            $requestStatement->execute($values);
            return true;
        } catch (\PDOException $e) {
            return false;
        }
    }

    public function getAll(): array
    {
        $pdo = Model::getPdo();
        $requestStatement = $pdo->query(" SELECT * 
                                                FROM ExperienceProfessionnel e
                                                JOIN Alternances a ON a.idAlternance = e.idExperienceProfessionnel");
        $AllAlternance = [];
        foreach ($requestStatement as $alternanceTab) {
            $AllAlternance[] = self::construireDepuisTableau($alternanceTab);
        }
        return $AllAlternance;
    }

    public function get(string $id): ?Alternance
    {
        $sql = "SELECT *
                FROM ExperienceProfessionnel e
                JOIN Alternances a ON a.idAlternance = e.idExperienceProfessionnel
                WHERE a.idAlternance = :id";
        $pdoStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "id" => $id,
        );

        $pdoStatement->execute($values);

        $alternance = $pdoStatement->fetch();

        // S'il n'y a pas d'alternance
        if (!$alternance) {
            return null;
        } else {
            return AlternanceRepository::construireDepuisTableau($alternance);
        }
    }

    public function mettreAJour(AbstractDataObject $alternance): void
    {

        // Il faut modifier à la fois dans ExperienceProfessionnel
        ExperienceProfessionnelRepository::mettreAJour($alternance);
    }

    public function supprimer(string $alternance): void
    {
        $sql = "DELETE FROM Alternances WHERE idAlternance= :idTag;";
        $pdoStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "idTag" => $alternance->getIdExperienceProfessionnel()
        );

        $pdoStatement->execute($values);
        ExperienceProfessionnelRepository::supprimer($alternance);
    }

    /*public static function filtre(string $dateDebut = null, string $dateFin = null, string $optionTri = null, string $codePostal = null, string $datePublication = null): array
    {
        date_default_timezone_set('Europe/Paris');
        $pdo = Model::getPdo();
        $sql = "SELECT * 
                FROM Alternances a JOIN ExperienceProfessionnel e ON a.idalternance = e.idExperienceProfessionnel WHERE numEtudiant IS NULL ";
        if (isset($datePublication)) {
            $sql .= match ($datePublication) {
                'last24' => "AND DATEDIFF(NOW(), datePublication) < 1 ",
                'lastWeek' => "AND DATEDIFF(NOW(), datePublication) < 7 ",
                'lastMonth' => "AND DATEDIFF(NOW(), datePublication) < 30 ",
            };
        }
        //TODO : A revoire quand Date dans BD
        if (strlen($dateDebut) > 0 && strlen($dateFin) > 0) {
            $sql .= "AND dateDebutExperienceProfessionnel >= $dateDebut AND dateFinExperienceProfessionnel <= $dateFin ";
        } elseif (strlen($dateDebut) > 0) {
            $sql .= "AND dateDebutExperienceProfessionnel = '$dateDebut' ";
        } elseif (strlen($dateFin) > 0) {
            $sql .= "AND dateFinExperienceProfessionnel = '$dateFin' ";
        }
        if (strlen($codePostal) > 0) {
            $sql .= "AND codePostalExperienceProfessionnel = '$codePostal' ";
        }
        if (isset($optionTri)) {
            if ($optionTri == "datePublication") {
                $sql .= "ORDER BY datePublication ASC";
            }
            if ($optionTri == "datePublicationInverse") {
                $sql .= "ORDER BY datePublication DESC";
            }
        }

        $requete = $pdo->query($sql);
        $alternanceTriee = [];
        foreach ($requete as $result) {
            $alternanceTriee[] = self::construireDepuisTableau($result);
        }
        return $alternanceTriee;
    }*/

    public static function search(string $keywords): array
    {
        /*$sql = "SELECT *
                FROM ExperienceProfessionnel e
                JOIN Alternances a ON a.idAlternance = e.idExperienceProfessionnel
                JOIN Entreprises en ON en.siret = e.siret
                WHERE numEtudiant IS NULL
                AND en.estValide = true
                AND (sujetExperienceProfessionnel LIKE :keywordsTag
                OR thematiqueExperienceProfessionnel LIKE :keywordsTag
                OR tachesExperienceProfessionnel LIKE :keywordsTag
                OR codePostalExperienceProfessionnel LIKE :keywordsTag
                OR adresseExperienceProfessionnel LIKE :keywordsTag
                OR e.siret LIKE :keywordsTag)
                ORDER BY datePublication";

        $requestStatement = Model::getPdo()->prepare($sql);

        $values = array(
            "keywordsTag" => '%' . $keywords . '%'
        );

        $requestStatement->execute($values);

        $AllAlternance = [];
        foreach ($requestStatement as $alternanceTab) {
            $AllAlternance[] = self::construireDepuisTableau($alternanceTab);
        }
        return $AllAlternance;*/
    }
}