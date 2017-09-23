<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MentorType extends AbstractType
{
  /**
   * {@inheritdoc}
   */
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
      $builder
      ->add('nombres')
      ->add('apellidos')
      ->add('tipoDocumentoIdentidad','entity',array(
        'class' => 'DataBundle:TipoDocumento',
        'query_builder' => function(EntityRepository $er){
          return $er->createQueryBuilder('d')->orderBy('d.id','ASC');
        },'choice_label'=>'getNombre','placeholder'=>'Seleccione una opcion'))
      ->add('numeroDocumento')
      ->add('fechaNacimiento')
      ->add('direccion')
      ->add('municipio')
      ->add('departamento')
      ->add('email', 'email')
      ->add('numeroMovil')
      ->add('numeroTelefono')
      ->add('password', 'password')
      ->add('eps')
      ->add('tipoSangre')
      ->add('activo', 'checkbox')
      ->add('tipoMentor')
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
