<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;

class GrupoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('jornada','entity',array(
              'class' => 'DataBundle:Jornada',
              'query_builder' => function(EntityRepository $er){
                return $er->createQueryBuilder('j')->orderBy('j.id','ASC');
              },'choice_label'=>'getNombre','placeholder'=>'Seleccione una opcion'))
            ->add('mentor','entity',array(
              'class' => 'DataBundle:Mentor',
              'query_builder' => function (EntityRepository $er){
                return $er->createQueryBuilder('m');
              },
              'choice_label' => 'getFullName'
            ))
            ->add('activo', 'checkbox')
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
        return 'grupo';
    }


}
