<?php

namespace RS\DepoStock\DepoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use RS\DepoStock\DepoBundle\Entity\Repositorio\ProductoRepository;
use RS\DepoStock\DepoBundle\Entity\Deposito;

class EnvioProductoType extends AbstractType
{
    
    protected $deposito;
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('producto', 'entity', array(
                'class' => 'DepoBundle:Producto', 'required' => true,
                'query_builder' => function (ProductoRepository $er) {
                    return $er->createQueryBuilder('p')
                            ->where('p.id in (:deposito)')
                            ->orderBy('p.id')
                            ->setParameter('deposito', $this->deposito->getProductosStock());
                }
            ))
            ->add('cantidad')
            ->add('cliente') 
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RS\DepoStock\DepoBundle\Entity\EnvioProducto'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'rs_depostock_depobundle_envioproducto';
    }
    
    public function __construct(Deposito $deposito) {
        $this->deposito = $deposito;
    }
}
