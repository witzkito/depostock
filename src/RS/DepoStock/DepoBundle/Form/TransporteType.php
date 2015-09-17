<?php

namespace RS\DepoStock\DepoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TransporteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, array('attr' => array('placeholder' => 'Nombre del Tranportista')))
            ->add('telefono', null, array('attr' => array('placeholder' => 'Telefono del Transportista'),
                                           'required' => false))
            ->add('patente',null, array('attr' => array('placeholder' => 'Patente del Tranporte'),
                                            'required' => false))
            ->add('nombreEmpresa', null, array('attr' => array('placeholder' => 'Nombre Empresa Transportista'),
                                            'required' => false))
            ->add('telefonoEmpresa', null, array('attr' => array('placeholder' => 'Telefono de la Empresa'),
                                           'required' => false))
            ->add('tipo', 'choice', array(
                'choices' => array("" => "Seleccionar Vehiculo", "Camion" => "Camion", "Camioneta" => "Camioneta"),
                'required' => false
            ))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RS\DepoStock\DepoBundle\Entity\Transporte'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_depostock_depobundle_transporte';
    }
}
