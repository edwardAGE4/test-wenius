<?php

namespace AppBundle\Form\Work;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VehiculeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('immatriculation')
            ->add('marque')
            ->add('modele')
            ->add('type')
            ->add('dateAchat', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'widget' => ('single_text'),
                'format' => 'd/M/y',
                'html5' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'date'
                )
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Work\Vehicule'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_car';
    }


}
