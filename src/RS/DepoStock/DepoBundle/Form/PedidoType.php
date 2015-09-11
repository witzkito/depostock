<?php

namespace RS\DepoStock\DepoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PedidoType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cliente', 'genemu_jqueryselect2_entity', array(
                "class" => "DepoBundle:Cliente",
                'label' => 'Cliente'))
            ->add('productos', 'collection', array('type' => new PedidoProductoType(),
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
            'data_class' => 'RS\DepoStock\DepoBundle\Entity\Pedido'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_depostock_depobundle_pedido';
    }
}
