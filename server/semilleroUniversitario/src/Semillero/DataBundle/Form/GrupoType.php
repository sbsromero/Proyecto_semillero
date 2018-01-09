<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


class GrupoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('nombre')
          ->add('cupo')
          ->add('activo', 'checkbox')
          ->add('diplomado','entity',array(
            'class' => 'DataBundle:Diplomado',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('d')->orderBy('d.id','ASC');
            },'choice_label'=>'getNombre','placeholder'=>'Seleccione una opción'))
          ->add('jornada','entity',array(
            'class' => 'DataBundle:Jornada',
            'query_builder' => function(EntityRepository $er){
              return $er->createQueryBuilder('j')->orderBy('j.id','ASC');
            },'choice_label'=>'getNombre','placeholder'=>'Seleccione una opcion'))
          ->add('semestre','entity',array(
              'class' => 'DataBundle:Semestre',
              'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('s')->orderBy('s.id','ASC');
                },'choice_label'=>'getStringSemestre','placeholder'=>'Seleccione una opción'))
          ->add('save','submit', array('label' => 'Guardar Grupo'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Semillero\DataBundle\Entity\Grupo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'semillero_databundle_grupo';
    }


}
