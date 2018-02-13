<?php

namespace Semillero\DataBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SemillaType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('urlImage',FileType::class, array('attr'=>array('multiple'=>'multiple')))
        ->add('nombre')
        ->add('apellidos')
        ->add('tipoDocumento','entity',array(
          'class' => 'DataBundle:TipoDocumento',
          'query_builder' => function(EntityRepository $er){
            return $er->createQueryBuilder('d');
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
        ->add('isFacebook', 'checkbox')
        ->add('emailFacebook')
        ->add('isWhatsapp', 'checkbox')
        ->add('gradoEscolarActual')
        ->add('colegio')
        ->add('enfermedades')
        ->add('acudienteUno')
        ->add('direccionAcudienteUno')
        ->add('telefonoAcudienteUno')
        ->add('acudienteDos')
        ->add('direccionAcudienteDos')
        ->add('telefonoAcudienteDos')
        // ->add('observaciones')
        // ->add('grupos','entity',array(
        //   'class' => 'DataBundle:Grupo',
        //   'choice_label' => function ($grupo) {
        //     return $grupo->getDiplomado()->getNombre();
        //   }
        // ))
        ->add('save','submit', array('label' => 'Guardar Semilla'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Semillero\DataBundle\Entity\Semilla'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'semilla';
    }


}
