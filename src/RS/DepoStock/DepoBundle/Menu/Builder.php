<?php
namespace RS\DepoStock\DepoBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root');
        
        $menu->setChildrenAttribute('class', 'nav navbar-nav acciones');
        $menu->addChild('Inicio', array('route' => 'depo_homepage'));
        
        $menu->addChild('Clientes', array('route' => 'cliente'));
        
        $menu->addChild('Productos', array('route' => 'producto'));
        
        $menu->addChild('Pedidos', array('route' => 'pedido'));
        
        $menu->addChild('Transportes', array('route' => 'transporte'));
        
        $menu->addChild('Envios', array('route' => 'envio'));
        
        $menu->addChild('Cuentas Corrientes', array('route' => 'cuentacorriente'));
        
        $menu->addChild('Salir', array('route' => 'fos_user_security_logout'));

        return $menu;
    }
}
