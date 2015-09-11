<?php

namespace RS\DepoStock\DepoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class DepositoAdmin extends Admin
{
    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('nombre')
            ->add('calle')
            ->add('numero')
            ->add('localidad')
            ->add('provincia')
            ->add('pais')
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('nombre')
            ->add('empresa')
            ->add('calle')
            ->add('numero')
            ->add('localidad')
            ->add('provincia')
            ->add('pais')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('nombre')
            ->add('empresa', 'entity', array('class' => 'DepoBundle:Empresa'))
            ->add('calle', null, array("required" => false))
            ->add('numero', null, array("required" => false))
            ->add('localidad', null, array("required" => false))
            ->add('provincia', null, array("required" => false))
            ->add('pais', null, array("required" => false))
            
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('nombre')
            ->add('calle')
            ->add('numero')
            ->add('localidad')
            ->add('provincia')
            ->add('pais')
        ;
    }
}
