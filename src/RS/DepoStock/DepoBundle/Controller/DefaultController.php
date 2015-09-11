<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->get('doctrine')->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entities = $em->getRepository('DepoBundle:UsuarioDeposito')->findBy(array('usuario' => $user->getId()));
        $empresa = $entities[0]->getDeposito()->getEmpresa();
        $pedidos = $empresa->getPedidos();
        return $this->render('DepoBundle:Default:index.html.twig', array("entities" => $entities, "pedidos" => $pedidos));
    }
}
