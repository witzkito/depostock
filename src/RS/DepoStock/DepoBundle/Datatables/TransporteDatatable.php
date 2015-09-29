<?php

namespace RS\DepoStock\DepoBundle\Datatables;

use Sg\DatatablesBundle\Datatable\View\AbstractDatatableView;
use Sg\DatatablesBundle\Datatable\View\Style;

/**
 * Class TransporteDatatable
 *
 * @package RS\DepoStock\DepoBundle\Datatables
 */
class TransporteDatatable extends AbstractDatatableView
{
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
            'url' => $this->router->generate('transporte_results'),
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
                ->add('nombre', 'column', array('title' => 'Nombre',))
                ->add('patente', 'column', array('title' => 'Patente',))
                ->add('telefono', 'column', array('title' => 'Telefono',))
                ->add('nombreEmpresa', 'column', array('title' => 'NombreEmpresa',))
                ->add('telefonoEmpresa', 'column', array('title' => 'TelefonoEmpresa',))
                ->add('tipo', 'column', array('title' => 'Tipo',))
                ->add(null, 'action', array(
                'title' => 'Acciones',
                'start_html' => '<div class="wrapper">',
                'end_html' => '</div>',
                'actions' => array(
                    array(
                        'route' => 'transporte_show',
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
                        'route' => 'transporte_edit',
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
        return 'RS\DepoStock\DepoBundle\Entity\Transporte';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'transporte_datatable';
    }
}
