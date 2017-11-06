<?php

namespace AppBundle\Form\Work;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sujet')
            ->add('description')
            ->add('dateDebut', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'widget' => ('single_text'),
                'format' => 'd/M/y',
                'html5' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'date'
                )
            ))
            ->add('dateFinPrevue', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'widget' => ('single_text'),
                'format' => 'd/M/y',
                'html5' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'date'
                )
            ))
            ->add('pieces', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
                'entry_type' => 'AppBundle\Form\Work\PieceType',
                'allow_add' => true,
                'delete_empty' => true,
                'by_reference' => false,
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Work\Operation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_operation';
    }


}
