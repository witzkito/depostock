<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use RS\DepoStock\DepoBundle\Entity\Cliente;
use RS\DepoStock\DepoBundle\Form\ClienteType;

/**
 * Cliente controller.
 *
 * @Route("/deposito")
 */
class DepositoController extends Controller
{

    /**
     * Lists all Pedido entities.
     *
     * @Route("/listar/{id}", name="show_deposito")
     * @Template()
     */
    public function listarAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DepoBundle:Deposito')->find($id);
        return array(
            'entity' => $entity,
        );
    }
    
}
