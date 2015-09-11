<?php

namespace RS\DepoStock\DepoBundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FotoProductoType extends AbstractType {
    
    public function buildForm( FormBuilderInterface $builder, array $options)
    {
        return $builder->add('file', 'file' ,array(
                        'required'  => true,
                        'label' => 'Archivo de Foto'
                    ));
    }
    
    public function getName() {
        return "Foto";
    }
    
    
}

?>
