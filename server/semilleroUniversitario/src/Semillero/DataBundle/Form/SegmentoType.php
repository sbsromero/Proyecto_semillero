<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SegmentoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('numeroSegmento')
        ->add('activo')
        ->add('semestres','entity', array(
          'class' => 'DataBundle:Semestre',
          'placeholder' => 'Seleccione una opcion',
          'choice_label' => function($semestres){
            return $semestres->getAnoSemestre()->format('Y');
          }
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Semillero\DataBundle\Entity\Segmento'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'segmento';
    }


}
