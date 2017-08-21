<?php
/**
 * Created by PhpStorm.
 * User: HarrylepaP
 * Date: 27/11/2016
 * Time: 15:00
 */
namespace Pharmacie\MedicamentBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class FournisseurAdmin extends AbstractAdmin{


    #similiare à buildForm dans Form
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('libelle', 'text');
    }

    #contenue du tableau d'affichage
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('libelle')
        ;
    }

    #tableau d'affichage par rapport à configureDatagridFilters
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id')
            ->addIdentifier('libelle')
        ;
    }
}