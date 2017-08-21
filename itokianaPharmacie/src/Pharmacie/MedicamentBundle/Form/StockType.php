<?php

namespace Pharmacie\MedicamentBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StockType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('dateEntree')
            ->add('datePeremption')
            ->add('nombre')
            ->add('medicament',EntityType::class,array(
                'class'=>'MedicamentBundle:Medicament',
                'choice_label'=>'libelle')
            )
            ->add('fournisseur',EntityType::class,array(
                'class'=>'MedicamentBundle:Fournisseur',
                'choice_label'=>'libelle')
            ) ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pharmacie\MedicamentBundle\Entity\Stock'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pharmacie_medicamentbundle_stock';
    }


}
