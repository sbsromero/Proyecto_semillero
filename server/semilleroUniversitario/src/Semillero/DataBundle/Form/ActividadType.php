<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ActividadType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('nombre')
        ->add('descripcion')
        ->add('observacion','textarea',array(
           'attr' => array('rows' => '5'),
        ))
        ->add('tipoActividad','entity',array(
          'class' => 'DataBundle:TipoActividad',
          'query_builder' => function(EntityRepository $er){
            return $er->createQueryBuilder('tA')->orderBy('tA.id','ASC');
          },'choice_label'=>'getNombre','placeholder'=>'Seleccion el tipo de actividad'
        ))
        ->add('save','button', array('label' => 'Registrar actividad'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Semillero\DataBundle\Entity\Actividad'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'actividad';
    }


}
