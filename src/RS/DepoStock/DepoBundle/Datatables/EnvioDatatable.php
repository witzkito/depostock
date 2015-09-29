<?php

namespace RS\DepoStock\DepoBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class EnvioDatatable
 *
 * @package RS\DepoStock\DepoBundle\Datatables
 */
class EnvioDatatable extends AbstractDatatableView
{
    
    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        $formatter = function($line){
            $repository = $this->em->getRepository($this->getEntity());
            $entity = $repository->find($line['id']);
            $line['total'] = "$ " . $entity->getTotal();            

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
            'url' => $this->router->generate('envio_results'),
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
            'class' => Style::BOOTSTRAP_3_STYLE . 'table table-striped',
            'individual_filtering' => false,
            'individual_filtering_position' => 'foot',
            'use_integration_options' => false
        ));

        $this->columnBuilder
                ->add('id', 'column', array('title' => 'Id',))
                ->add('fecha', 'datetime', array('title' => 'Fecha',))
                ->add('transporte.nombre', 'column', array('title' => 'Transporte Nombre',))
                ->add('total', 'virtual', array('title' => 'Total'))
                ->add(null, 'action', array(
                'title' => 'Acciones',
                'start_html' => '<div class="wrapper">',
                'end_html' => '</div>',
                'actions' => array(
                    array(
                        'route' => 'show_envio',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => 'Ver',
                        'icon' => 'glyphicon glyphicon-eye-open',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Ver',
                            'class' => 'btn btn-default btn-xs',
                            'role' => 'button'
                        ),
                    ),
                    array(
                        'route' => 'edit_envio',
                        'route_parameters' => array(
                            'id' => 'id'
                        ),
                        'label' => "Editar",
                        'icon' => 'glyphicon glyphicon-edit',
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => "Editar",
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                    )
                )))
                ;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'RS\DepoStock\DepoBundle\Entity\Envio';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'envio_datatable';
    }
}
