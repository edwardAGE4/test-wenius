<?php

namespace AppBundle\Form\Work;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProblemeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('resume')
            ->add('description')
            ->add('dateDetection', 'Symfony\Component\Form\Extension\Core\Type\DateType', array(
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
            'data_class' => 'AppBundle\Entity\Work\Probleme'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_problem';
    }


}
