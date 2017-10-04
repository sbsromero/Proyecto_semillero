<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MentorType extends AbstractType
{
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder
      ->add('nombre')
      ->add('apellidos')
      ->add('tipoDocumento','entity',array(
        'class' => 'DataBundle:TipoDocumento',
        'query_builder' => function(EntityRepository $er){
          return $er->createQueryBuilder('d');//->orderBy('d.id','ASC');
        },'choice_label'=>'getNombre','placeholder'=>'Seleccione una opcion'))
      ->add('numeroDocumento')
      ->add('fechaNacimiento',DateType::class, array(
        'widget' => 'single_text',
        'html5' => false,
        'format' => 'dd/MM/yyyy'
      ))
      ->add('direccion')
      ->add('municipio')
      ->add('departamento')
      ->add('email', 'email')
      ->add('numeroCelular')
      ->add('numeroTelefono')
      ->add('password', 'password')
      ->add('eps')
      ->add('tipoSangre')
      // ->add('activo', 'checkbox')
      ->add('tipoMentor','entity',array(
        'class' => 'DataBundle:TipoMentor',
        'query_builder' => function(EntityRepository $er){
          return $er->createQueryBuilder('t');
        },'choice_label'=>'getNombre','placeholder'=>'Seleccione una opcion'))
      ->add('save','submit', array('label' => 'Guardar Mentor'));
  }

  /**
   * {@inheritdoc}
   */
  public function configureOptions(OptionsResolver $resolver)
  {
      $resolver->setDefaults(array(
          'data_class' => 'Semillero\DataBundle\Entity\Mentor'
      ));
  }

  /**
   * {@inheritdoc}
   */
  public function getBlockPrefix()
  {
      return 'mentor';
  }
}
