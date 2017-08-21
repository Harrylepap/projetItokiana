<?php
/**
 * Created by PhpStorm.
 * User: HarrylepaP
 * Date: 27/11/2016
 * Time: 15:01
 */
namespace Pharmacie\MedicamentBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MedicamentAdmin extends AbstractAdmin{


    #similiare à buildForm dans Form
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('libelle','text',array('label'=>'Nom médicament'))
            ->add('file','file', array('label' => 'Image miniature'))
            ->add('dose', 'textarea')
            ->add('nombre')
            ->add('unite','entity',  array(
                'class' => 'MedicamentBundle:Unite',
                'choice_label' => 'Type',))
            ->add('sorte','entity', array(
                    'class' => 'MedicamentBundle:Sorte',
                    'choice_label' => 'libelle',)
            )
            ->add('prix','text',array('label'=>'Prix médicament'));
    }

    #contenue du tableau d'affichage
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('libelle')
            ->add('dose')
            ->add('nombre')
            ->add('unite.type')
            ->add('sorte.libelle')
            ->add('prix')
            ->add('pictureName')
        ;
    }

    #tableau d'affichage par rapport à configureDatagridFilters
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('libelle' )
            ->addIdentifier('dose')
            ->addIdentifier('nombre')
            ->addIdentifier('unite.type')
            ->addIdentifier('sorte.libelle')
            ->addIdentifier('prix')
            ->addIdentifier('pictureName')
        ;
    }
    public function prePersist($medicament)
    {
        $this->manageFileUpload($medicament);
    }

    public function preUpdate($medicament)
    {
        $this->manageFileUpload($medicament);
    }

    private function manageFileUpload($medicament)
    {
        if ($medicament->file) {
            $medicament->uploadProfilePicture();
        }
    }
}