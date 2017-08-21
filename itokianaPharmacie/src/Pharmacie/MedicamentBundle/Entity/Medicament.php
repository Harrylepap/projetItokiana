<?php

namespace Pharmacie\MedicamentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Medicament
 *
 * @ORM\Table(name="medicament")
 * @ORM\Entity(repositoryClass="Pharmacie\MedicamentBundle\Repository\MedicamentRepository")
 */
class Medicament
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
     * @ORM\ManyToOne(targetEntity="Pharmacie\MedicamentBundle\Entity\Unite")
     * @ORM\JoinColumn(nullable=true)
     */
    private $unite;

    /**
     * @ORM\ManyToMany(targetEntity="Pharmacie\MedicamentBundle\Entity\Categorie", cascade={"persist"})
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity="Pharmacie\MedicamentBundle\Entity\Sorte")
     * @ORM\JoinColumn(nullable=true)
     */
    private $sorte;

    /**
     * @var int
     *
     * @ORM\Column(name="prix", type="integer", nullable=true)
     */
    private $prix;


    /**
     * @var string
     *
     * @ORM\Column(name="libelle", type="string", length=255)
     */
    private $libelle;

    ////////////////////////////////////////////////////////////////////////////////////
    //Uploader une image
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $pictureName;

    /**
     * @Assert\File(maxSize="1000k")
     */
    public $file;

    public function getWebPath()
    {
        return null === $this->pictureName ? null : $this->getUploadDir().'/'.$this->pictureName;
    }

    protected function getUploadRootDir()
    {
        // le chemin absolu du répertoire dans lequel sauvegarder les photos de profil
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function
    getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'img/upload/';
    }

    public function uploadProfilePicture()
    {
        // Nous utilisons le nom de fichier original, donc il est dans la pratique
        // nécessaire de le nettoyer pour éviter les problèmes de sécurité

        // move copie le fichier présent chez le client dans le répertoire indiqué.
        $this->file->move($this->getUploadRootDir(), $this->file->getClientOriginalName());

        // On sauvegarde le nom de fichier
        $this->pictureName = $this->file->getClientOriginalName();

        // La propriété file ne servira plus
        $this->file = null;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////:

    /**
     * @var string
     *
     * @ORM\Column(name="dose", type="string", length=255)
     */
    private $dose;

    /**
     * @var int
     *
     * @ORM\Column(name="nombre", type="integer")
     */
    private $nombre;


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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Medicament
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set dose
     *
     * @param string $dose
     *
     * @return Medicament
     */
    public function setDose($dose)
    {
        $this->dose = $dose;

        return $this;
    }

    /**
     * Get dose
     *
     * @return string
     */
    public function getDose()
    {
        return $this->dose;
    }

    /**
     * Set nombre
     *
     * @param integer $nombre
     *
     * @return Medicament
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
     * Constructor
     */
    public function __construct()
    {
        $this->categorie = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set unite
     *
     * @param \Pharmacie\MedicamentBundle\Entity\Unite $unite
     *
     * @return Medicament
     */
    public function setUnite(\Pharmacie\MedicamentBundle\Entity\Unite $unite = null)
    {
        $this->unite = $unite;

        return $this;
    }

    /**
     * Get unite
     *
     * @return \Pharmacie\MedicamentBundle\Entity\Unite
     */
    public function getUnite()
    {
        return $this->unite;
    }

    /**
     * Add categorie
     *
     * @param \Pharmacie\MedicamentBundle\Entity\Categorie $categorie
     *
     * @return Medicament
     */
    public function addCategorie(\Pharmacie\MedicamentBundle\Entity\Categorie $categorie)
    {
        $this->categorie[] = $categorie;

        return $this;
    }

    /**
     * Remove categorie
     *
     * @param \Pharmacie\MedicamentBundle\Entity\Categorie $categorie
     */
    public function removeCategorie(\Pharmacie\MedicamentBundle\Entity\Categorie $categorie)
    {
        $this->categorie->removeElement($categorie);
    }

    /**
     * Get categorie
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set sorte
     *
     * @param \Pharmacie\MedicamentBundle\Entity\Sorte $sorte
     *
     * @return Medicament
     */
    public function setSorte(\Pharmacie\MedicamentBundle\Entity\Sorte $sorte = null)
    {
        $this->sorte = $sorte;

        return $this;
    }

    /**
     * Get sorte
     *
     * @return \Pharmacie\MedicamentBundle\Entity\Sorte
     */
    public function getSorte()
    {
        return $this->sorte;
    }

    /**
     * Set prix
     *
     * @param integer $prix
     *
     * @return Medicament
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set pictureName
     *
     * @param string $pictureName
     *
     * @return Medicament
     */
    public function setPictureName($pictureName)
    {
        $this->pictureName = $pictureName;

        return $this;
    }

    /**
     * Get pictureName
     *
     * @return string
     */
    public function getPictureName()
    {
        return $this->pictureName;
    }

    public function getFile()
    {
        return $this->file;
    }

    public function setFile($file)
    {
        $this->file=$file;
    }
}
