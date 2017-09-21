<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
      ->add('tipoDocumentoIdentidad','choice',array('choices'=>array('T.I' => 'Tarjeta De Identidad','C.C' => 'Cedula'),
       'placeholder' => 'Seleccionar Tipo de Documento'))
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
      ->add('save','submit', array('label' => 'Guardar Mentor'))
      ;
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
