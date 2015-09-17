<?php

namespace RS\DepoStock\DepoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IngresoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('transporte')
            ->add('fecha', 'collot_datetime')
            ->add('productos', 'collection', array('type' => new IngresoProductoType(),
                                                            'allow_add'    => true,
                                                            'by_reference' => false,
                                                            'allow_delete' => true))            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RS\DepoStock\DepoBundle\Entity\Ingreso'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_depostock_depobundle_ingreso';
    }

}
