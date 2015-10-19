<?php

namespace RS\DepoStock\DepoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use RS\DepoStock\DepoBundle\Form\EnvioProductoType;
use RS\DepoStock\DepoBundle\Entity\Deposito;

class EnvioType extends AbstractType
{
    
    protected $deposito;


    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fecha', 'collot_datetime', array( 'pickerOptions' =>
            array('format' => 'mm/dd/yyyy h:i')))
                ->add('transporte', 'genemu_jqueryselect2_entity', array(
                "class" => "DepoBundle:Transporte",
                'label' => 'Transporte',
                'required' => true))
                ->add('productos', 'collection', array('type' => new EnvioProductoType($this->deposito),
                    'allow_add' => true, 'required' => true));
            
            
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_depostock_depobundle_envio';
    }
    
    public function __construct(Deposito $deposito) {
        $this->deposito = $deposito;
    }
}
