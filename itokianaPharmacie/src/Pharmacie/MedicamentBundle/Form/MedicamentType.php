<?php

namespace Pharmacie\MedicamentBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MedicamentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('libelle')
            ->add('file')
            ->add('dose')
            ->add('nombre')
            ->add('unite',EntityType::class,  array(
                'class' => 'MedicamentBundle:Unite',
                'choice_label' => 'Type',))
            ->add('sorte',EntityType::class, array(
                'class' => 'MedicamentBundle:Sorte',
                'choice_label' => 'libelle',)
                )
            ->add('prix');
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Pharmacie\MedicamentBundle\Entity\Medicament'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'pharmacie_medicamentbundle_medicament';
    }


}
