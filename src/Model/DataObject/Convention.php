<?php

namespace App\SAE\Model\DataObject;

class Convention extends AbstractDataObject {

    private string $idConvention;
    private string $idStage;
    private string $competencesADevelopper;
    private string $dureeDeTravail;
    private string $languesImpression;
    private string $origineDeLaConvention;
    private bool $sujetEstConfidentiel;
    private string $dureeExperienceProfessionnel;
    private string $nbHeuresHebdo;
    private string $modePaiement;
    private string $caisseAssuranceMaladie;
    private bool $estSignee;
    private bool $estValidee;

    public function getIdConvention(): string
    {
        return $this->idConvention;
    }

    public function setIdConvention(string $idConvention): void
    {
        $this->idConvention = $idConvention;
    }

    public function getCompetencesADevelopper(): string
    {
        return $this->competencesADevelopper;
    }

    public function setCompetencesADevelopper(string $competencesADevelopper): void
    {
        $this->competencesADevelopper = $competencesADevelopper;
    }

    public function getLanguesImpression(): string
    {
        return $this->languesImpression;
    }

    public function setLanguesImpression(string $languesImpression): void
    {
        $this->languesImpression = $languesImpression;
    }

    public function getDureeStage(): string
    {
        return $this->dureeStage;
    }

    public function setDureeStage(string $dureeStage): void
    {
        $this->dureeStage = $dureeStage;
    }

    public function getNbHeuresHebdo(): string
    {
        return $this->nbHeuresHebdo;
    }

    public function setNbHeuresHebdo(string $nbHeuresHebdo): void
    {
        $this->nbHeuresHebdo = $nbHeuresHebdo;
    }

    public function getModePaiement(): string
    {
        return $this->modePaiement;
    }

    public function setModePaiement(string $modePaiement): void
    {
        $this->modePaiement = $modePaiement;
    }

    public function getEstSignee(): string
    {
        return $this->estSignee;
    }

    public function setEstSignee(string $estSignee): void
    {
        $this->estSignee = $estSignee;
    }

    public function getIdStage(): string
    {
        return $this->idStage;
    }

    public function setIdStage(string $idStage): void
    {
        $this->idStage = $idStage;
    }

    public function getDureeDeTravail(): string
    {
        return $this->dureeDeTravail;
    }

    public function setDureeDeTravail(string $dureeDeTravail): void
    {
        $this->dureeDeTravail = $dureeDeTravail;
    }

    public function getOrigineDeLaConvention(): string
    {
        return $this->origineDeLaConvention;
    }

    public function setOrigineDeLaConvention(string $origineDeLaConvention): void
    {
        $this->origineDeLaConvention = $origineDeLaConvention;
    }

    public function isSujetEstConfidentiel(): bool
    {
        return $this->sujetEstConfidentiel;
    }

    public function setSujetEstConfidentiel(bool $sujetEstConfidentiel): void
    {
        $this->sujetEstConfidentiel = $sujetEstConfidentiel;
    }

    public function getDureeExperienceProfessionnel(): string
    {
        return $this->dureeExperienceProfessionnel;
    }

    public function setDureeExperienceProfessionnel(string $dureeExperienceProfessionnel): void
    {
        $this->dureeExperienceProfessionnel = $dureeExperienceProfessionnel;
    }

    public function getCaisseAssuranceMaladie(): string
    {
        return $this->caisseAssuranceMaladie;
    }

    public function setCaisseAssuranceMaladie(string $caisseAssuranceMaladie): void
    {
        $this->caisseAssuranceMaladie = $caisseAssuranceMaladie;
    }

    public function isEstValidee(): bool
    {
        return $this->estValidee;
    }

    public function setEstValidee(bool $estValidee): void
    {
        $this->estValidee = $estValidee;
    }

    public function formatTableau(): array {
        return array(
            "idConventionTag" => $this->idConvention,
            "idStageTag" => $this->idStage,
            "competencesADevelopperTag" => $this->competencesADevelopper,
            "dureeDeTravailTag" => $this->dureeDeTravail,
            "languesImpressionTag" => $this->languesImpression,
            "origineDeLaConventionTag" => $this->origineDeLaConvention,
            "sujetEstConfidentielTag" => $this->sujetEstConfidentiel,
            "nbHeuresHebdoTag" => $this->nbHeuresHebdo,
            "modePaiementTag" => $this->modePaiement,
            "dureeExperienceProfessionnelTag" => $this->dureeExperienceProfessionnel,
            "caisseAssuranceMaladieTag" => $this->caisseAssuranceMaladie,
            "estSigneeTag" => $this->estSignee,
            "estValideeTag" => $this->estValidee
        );
    }
}