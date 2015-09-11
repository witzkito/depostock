<?php

namespace RS\DepoStock\DepoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ClienteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', null, array('attr' => array('placeholder' => 'Nombre del Cliente')))
            ->add('localidad', null, array('required' => false,
                            'attr' => array('placeholder' => 'Localidad del Cliente')))
            ->add('calle', null, array('required' => false, 
                            'attr' => array('placeholder' => 'Calle del Cliente')))
            ->add('numero', null, array('required' => false,
                            'attr' => array('placeholder' => 'Numero de la calle del Cliente')))
            ->add('telefono', null, array('required' => false, 
                            'attr' => array('placeholder' => 'Telefono del Clietne')))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RS\DepoStock\DepoBundle\Entity\Cliente'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_depostock_depobundle_cliente';
    }
}
