<?php

namespace RS\DepoStock\DepoBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class PedidoDatatable
 *
 * @package RS\DepoStock\DepoBundle\Datatables
 */
class PedidoDatatable extends AbstractDatatableView
{
    
    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        $formatter = function($line){
            $repository = $this->em->getRepository($this->getEntity());
            $entity = $repository->find($line['id']);
            if ($entity->realizado())
            {
                $line['realizado'] = "SI";
            }else{
                $line['realizado'] = "NO";
            }
            

            return $line;
         
        };
        return $formatter;
        
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildDatatable()
    {
        $this->features->setFeatures(array(
            'auto_width' => true,
            'defer_render' => false,
            'info' => true,
            'jquery_ui' => false,
            'length_change' => true,
            'ordering' => true,
            'paging' => true,
            'processing' => true,
            'scroll_x' => false,
            'scroll_y' => '',
            'searching' => true,
            'server_side' => true,
            'state_save' => false,
            'delay' => 0
        ));

                $this->ajax->setOptions(array(
            'url' => $this->router->generate('pedido_results'),
            'type' => 'GET'
        ));
        
        $this->options->setOptions(array(
            'display_start' => 0,
            'defer_loading' => -1,
            'dom' => 'lfrtip',
            'length_menu' => array(10, 25, 50, 100),
            'order_classes' => true,
            'order' => array(array(0, 'asc')),
            'order_multi' => true,
            'page_length' => 10,
            'paging_type' => Style::FULL_NUMBERS_PAGINATION,
            'renderer' => '',
            'scroll_collapse' => false,
            'search_delay' => 0,
            'state_duration' => 7200,
            'stripe_classes' => array(),
            'responsive' => false,
            'class' => Style::BASE_STYLE,
            'individual_filtering' => false,
            'individual_filtering_position' => 'foot',
            'use_integration_options' => false
        ));

        $this->columnBuilder
                ->add('id', 'column', array('title' => 'Id',))
                ->add('fecha', 'datetime', array('title' => 'Fecha',))
                ->add('cliente.nombre', 'column', array('title' => 'Cliente Nombre',))
                ->add('realizado', 'virtual', array('title' => 'Realizado'))
                ;
    }
    
    


    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'RS\DepoStock\DepoBundle\Entity\Pedido';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pedido_datatable';
    }
}
