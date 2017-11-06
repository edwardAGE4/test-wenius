<?php

namespace AppBundle\Form\Work;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InterventionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateIntervention', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
                'widget' => ('single_text'),
                'format' => 'd/M/y',
                'html5' => false,
                'read_only' => true,
                'attr' => array(
                    'class' => 'date'
                )
            ))
            ->add('notes')
            ->add('images', 'Symfony\Component\Form\Extension\Core\Type\CollectionType', array(
                'entry_type' => 'AppBundle\Form\Media\ImageType',
                'allow_add' => true,
                'delete_empty' => true,
                'by_reference' => false,
                'entry_options' => array(
                    'label' => false,
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
            'data_class' => 'AppBundle\Entity\Work\Intervention'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_intervention';
    }


}
