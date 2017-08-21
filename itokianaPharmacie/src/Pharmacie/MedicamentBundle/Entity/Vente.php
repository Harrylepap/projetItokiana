<?php

namespace Pharmacie\MedicamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vente
 *
 * @ORM\Table(name="vente")
 * @ORM\Entity(repositoryClass="Pharmacie\MedicamentBundle\Repository\VenteRepository")
 */
class Vente
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="daty", type="datetime")
     */
    private $daty;

    /**
     * @var string
     *
     * @ORM\Column(name="personne", type="string", length=255, nullable=true)
     */
    private $personne;

    /**
     * @ORM\ManyToOne(targetEntity="Pharmacie\UtilisateurBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    /**
     * @ORM\ManyToOne(targetEntity="Pharmacie\MedicamentBundle\Entity\Medicament")
     * @ORM\JoinColumn(nullable=true)
     */
    private $medicament;

    /**
     * @var int
     *
     * @ORM\Column(name="prixUnitaire", type="integer")
     */
    private $prixUnitaire;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;


    /**
     * @var float
     *
     * @ORM\Column(name="somme", type="float")
     */
    private $somme;

    /**
     * Vente constructor.
     * @param string $personne
     * @param $utilisateur
     * @param $medicament
     * @param int $nombre
     */
    public function __construct($personne, $utilisateur, $medicament, $nombre)
    {
        $this->personne = $personne;
        $this->utilisateur = $utilisateur;
        $this->medicament = $medicament;
        $this->prixUnitaire = $medicament->getPrix();
        $this->nombre = $nombre;
        $this->daty = (new \DateTime());
        $this->somme = $this->prixUnitaire * $nombre;
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set daty
     *
     * @param \DateTime $daty
     *
     * @return Vente
     */
    public function setDaty($daty)
    {
        $this->daty = $daty;

        return $this;
    }

    /**
     * Get daty
     *
     * @return \DateTime
     */
    public function getDaty()
    {
        return $this->daty;
    }

    /**
     * Set personne
     *
     * @param string $personne
     *
     * @return Vente
     */
    public function setPersonne($personne)
    {
        $this->personne = $personne;

        return $this;
    }

    /**
     * Get personne
     *
     * @return string
     */
    public function getPersonne()
    {
        return $this->personne;
    }

    /**
     * Set prixUnitaire
     *
     * @param float $prixUnitaire
     *
     * @return Vente
     */
    public function setPrixUnitaire($prixUnitaire)
    {
        $this->prixUnitaire = $prixUnitaire;

        return $this;
    }

    /**
     * Get prixUnitaire
     *
     * @return float
     */
    public function getPrixUnitaire()
    {
        return $this->prixUnitaire;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     *
     * @return Vente
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return int
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set somme
     *
     * @param float $somme
     *
     * @return Vente
     */
    public function setSomme($somme)
    {
        $this->somme = $somme;

        return $this;
    }

    /**
     * Get somme
     *
     * @return float
     */
    public function getSomme()
    {
        return $this->somme;
    }

    /**
     * Set utilisateur
     *
     * @param \Pharmacie\UtilisateurBundle\Entity\Utilisateur $utilisateur
     *
     * @return Vente
     */
    public function setUtilisateur(\Pharmacie\UtilisateurBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Pharmacie\UtilisateurBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }
    

    /**
     * Set medicament
     *
     * @param \Pharmacie\MedicamentBundle\Entity\Medicament $medicament
     *
     * @return Vente
     */
    public function setMedicament(\Pharmacie\MedicamentBundle\Entity\Medicament $medicament = null)
    {
        $this->medicament = $medicament;

        return $this;
    }

    /**
     * Get medicament
     *
     * @return \Pharmacie\MedicamentBundle\Entity\Medicament
     */
    public function getMedicament()
    {
        return $this->medicament;
    }
    
}
