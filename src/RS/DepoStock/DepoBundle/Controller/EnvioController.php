<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use RS\DepoStock\DepoBundle\Entity\Envio;
use RS\DepoStock\DepoBundle\Form\EnvioType;
use RS\DepoStock\DepoBundle\Entity\EnvioProducto;
use Symfony\Component\HttpFoundation\Request;
use RS\DepoStock\DepoBundle\Form\EnvioGastoType;
use RS\DepoStock\DepoBundle\Entity\Caja;
use RS\DepoStock\DepoBundle\Entity\CuentaCorriente;
use Symfony\Component\HttpFoundation\Response;

class EnvioController extends Controller
{
    /**
     * @Route("/envio/new/{id}", name="new_envio")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $deposito= $em->getRepository('DepoBundle:Deposito')->find($id);
        $empresa = $deposito->getEmpresa();
        $pedidos = $empresa->getPedidos($deposito);
        $form = $this->createForm(new EnvioType());
        $arrayPedido = array();
        foreach ($pedidos as $pedido){
            foreach ($pedido->getProductos() as $producto)
            {
                if ($deposito->tieneProducto($producto)){
                    $form->add($producto->getId(), "checkbox", array('required' => 'false'));
                    $arrayPedido[] = $producto;
                }
            }
        }
        $request = $this->get('request');
        if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $data = $form->getData();
            $envio = new Envio();
            $envio->setFecha($data['fecha']);
            $envio->setTransporte($data['transporte']);
            foreach ($pedidos as $pedido){
                foreach ($pedido->getProductos() as $producto)
                {
                    if ($data[$producto->getId()]){
                        $envioProducto = new EnvioProducto();
                        $envioProducto->setCantidad($producto->getCantidad());
                        $envioProducto->setProducto($producto->getProducto());
                        $envioProducto->setEnvio($envio);
                        $envioProducto->setCliente($pedido->getCliente());
                        $envioProducto->setPrecio($producto->getProducto()->getPrecio());
                        $em->persist($envioProducto);
                        $producto->setRealizado(true);
                        $em->persist($producto);
                    }
                }
            }
            $envio->setDeposito($deposito);
            $em->persist($envio);
            $em->flush();
            return $this->redirect($this->generateUrl('show_envio', array('id' => $envio->getId())));
        } 
        return array(
                "deposito" => $deposito,
                "pedidos" => $arrayPedido,
                "form" => $form->createView()
            );    
       
    }
    
    /**
     * Lists all Pedido entities.
     *
     * @Route("/envio/index", name="envio")
     * @Template()
     */
    public function indexAction()
    {
        $datatable = $this->get('depo.datatable.envio');
        $datatable->buildDatatable();

        return array(
            'datatable' => $datatable,
        ); 
    }
    
    /**
    * Get all Envio entities.
    *
    * @Route("/results", name="envio_results")
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function indexResultsAction()
   {
       $datatable = $this->get('depo.datatable.envio');
       $datatable->buildDatatable();

       $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

       return $query->getResponse();
   }
    
    /**
     * Lists o une entity.
     *
     * @Route("/envio/show/{id}", name="show_envio", options={"expose"=true})
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('DepoBundle:Envio')->find($id);
        return array(
            'entity' => $entity,  'delete_form' => $this->createDeleteForm($id)->createView()
        );
    }
    
    /**
     * Creates a form to delete a Pedido entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('envio_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
    
    /**
     * Deletes a Producto entity.
     *
     * @Route("/delete/{id}", name="envio_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DepoBundle:Envio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Envio entity.');
            }
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('envio'));
    }
    
    /**
     * Displays a form to edit an existing Pedido entity.
     *
     * @Route("/envio/edit/{id}", name="edit_envio", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Pedido')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Pedido entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * @Route("/envio/completar/{id}", name="completar_envio")
     * @Template()
     */
    public function completarAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $envio= $em->getRepository('DepoBundle:Envio')->find($id);
        $form = $this->createForm(new EnvioGastoType());
        $form->setData(array('gastos' => $envio->getGastos()));
        $arrayProductos = array();
        foreach ($envio->getProductos() as $prod)
        {
            if ($prod->getConfirmado()){
                $form->add("conf_".$prod->getId(), "checkbox", array('required' => false, "attr" => array( 'checked' => true)));
            }else{
                $form->add("conf_".$prod->getId(), "checkbox", array('required' => false));
            }
            $form->add("cant_".$prod->getId(), "text", array('required' => false, 'data' => $prod->getPagado()));
            $arrayProductos[] = $prod;
        }
        $request = $this->get('request');
        if ($request->getMethod() == 'POST'){
            $form->bind($request);
            $data = $form->getData();
            $totalGastoAnterior = 0;
            foreach($envio->getGastos() as $gasto){
                $totalGastoAnterior = $totalGastoAnterior + $gasto->getCantidad();
            }
            $totalGastos = 0;
            foreach ($data['gastos'] as $gasto){
                $totalGastos = $totalGastos + $gasto->getCantidad();
            }
            if ($totalGastos != $totalGastoAnterior){
                foreach($envio->getGastos() as $gasto){
                    $em->remove($gasto);
                }
                $em->flush();
                foreach ($data['gastos'] as $gasto){
                    $envio->addGasto($gasto);
                    $gasto->setEnvio($envio);
                    $em->persist($gasto);
                }
                $caja = new Caja();
                $caja->setDeposito($envio->getDeposito());
                $caja->setFecha(new \DateTime('now'));
                $caja->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                    
                if ($totalGastoAnterior == 0){
                    $caja->setDescripcion("Gastos de envio transporte ". $envio->getTransporte()->getNombre());
                    $caja->setIngreso(0);
                    $caja->setEgreso($totalGastos - $totalGastoAnterior);                    
                }else{
                    $caja->setDescripcion("Cambio en los Gastos de envio transporte ". $envio->getTransporte()->getNombre());
                    if (($totalGastos - $totalGastoAnterior) < 0){
                        $caja->setIngreso($totalGastoAnterior - $totalGastos);
                        $caja->setEgreso(0);
                    }else{
                        $caja->setIngreso(0);
                        $caja->setEgreso($totalGastos - $totalGastoAnterior);
                    }
                }
                $em->persist($caja);
                $em->flush();
            }           
                  
            foreach ($envio->getProductos() as $prod){
               
                /*$caja = new Caja();
                $caja->setDeposito($envio->getDeposito());
                $caja->setFecha(new \DateTime('now'));
                $caja->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                if ($data['conf_' . $prod->getId()] != $prod->getConfirmado()){
                    if ($data['conf_' . $prod->getId()]){
                        $caja->setDescripcion("Venta a ". $prod->getCliente()->getNombre() . " de " . $prod->getProducto()->getNombre());
                        $caja->setIngreso($data['cant_' . $prod->getId()]);
                        $caja->setEgreso(0);
                    }else{
                        $caja->setDescripcion("Cancelacion Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                        $caja->setIngreso(0);
                        $caja->setEgreso($data['cant_' . $prod->getId()]);
                    }
                    $em->persist($caja);
                }else{
                    if ($data['cant_' . $prod->getId()] != $prod->getPagado()){
                        $diferencia = $data['cant_' . $prod->getId()] - $prod->getPagado();
                        if ($diferencia > 0){
                            $caja->setDescripcion("Cambio cantidad pagado Venta a ". $prod->getCliente()->getNombre() . " de " . $prod->getProducto()->getNombre());
                            $caja->setIngreso($diferencia);
                            $caja->setEgreso(0);
                            
                        }else{
                            $caja->setDescripcion("Cambio cantidad pagado Venta a ". $prod->getCliente()->getNombre() . " de " . $prod->getProducto()->getNombre());
                            $caja->setIngreso(0);
                            $caja->setEgreso(abs($diferencia));
                        }
                    }
                    if ($data['cant_' . $prod->getId()] != $prod->getTotal()){
                        $diferencia = $prod->getTotal() - $data['cant_' . $prod->getId()];
                        $cuentaCorriente = new CuentaCorriente();
                        $cuentaCorriente->setCliente($prod->getCliente());
                        $cuentaCorriente->setDescripcion("Venta de " . $prod->getProducto()->getNombre());
                        $cuentaCorriente->setIngreso($diferencia);
                        $cuentaCorriente->setEgreso(0);
                        $cuentaCorriente->setFecha(new \DateTime('now'));
                        $cuentaCorriente->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                        $em->persist($cuentaCorriente);
                    }
                    $em->persist($caja);
                }
                $prod->setPagado($data['cant_' . $prod->getId()]);
                $prod->setConfirmado($data['conf_' . $prod->getId()]);
                $em->persist($prod);*/ 
                
                $caja = new Caja();
                $caja->setDeposito($envio->getDeposito());
                $caja->setFecha(new \DateTime('now'));
                $caja->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                
                if ($data['cant_' . $prod->getId()] == null)
                {
                    $data['cant_' . $prod->getId()] = 0;
                }
                
                if ($data['conf_' . $prod->getId()]){
                    if ($prod->getEnvio()->getCompletado()){
                        $diferencia = $data['cant_' . $prod->getId()] - $prod->getTotal();
                        if ($diferencia != 0){
                            $difPagado = $data['cant_' . $prod->getId()] - $prod->getPagado();
                            if ($diferencia < 0){
                                //a caja la diferencia
                                $caja->setDescripcion("Cambio en Venta a ". $prod->getCliente()->getNombre() . " de " . $prod->getProducto()->getNombre());
                                $caja->setIngreso($difPagado);
                                $caja->setEgreso(0);
                                // restar de cuenta corriente
                                $cuentaCorriente = new CuentaCorriente();
                                $cuentaCorriente->setCliente($prod->getCliente());
                                $cuentaCorriente->setDescripcion("Cambio Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                                $cuentaCorriente->setEgreso($difPagado);
                                $cuentaCorriente->setIngreso(0);
                                $cuentaCorriente->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                                $cuentaCorriente->setFecha(new \DateTime('now'));
                                $em->persist($cuentaCorriente);
                                $em->persist($caja);
                            }else{
                                $caja->setDescripcion("Cambio Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                                $caja->setIngreso(0);
                                $caja->setEgreso($difPagado);
                                
                                // sumar cuenta corriente
                                $cuentaCorriente = new CuentaCorriente();
                                $cuentaCorriente->setCliente($prod->getCliente());
                                $cuentaCorriente->setDescripcion("Cambio Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                                $cuentaCorriente->setEgreso(0);
                                $cuentaCorriente->setIngreso($difPagado);
                                $cuentaCorriente->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                                $cuentaCorriente->setFecha(new \DateTime('now'));
                                $em->persist($cuentaCorriente);
                                $em->persist($caja);
                            }
                        }else{
                            $difPagado = $data['cant_' . $prod->getId()] - $prod->getPagado();
                            
                            $caja->setDescripcion("Cambio en Venta a ". $prod->getCliente()->getNombre() . " de " . $prod->getProducto()->getNombre());
                            $caja->setIngreso($difPagado);
                            $caja->setEgreso(0);
                            $cuentaCorriente = new CuentaCorriente();
                            $cuentaCorriente->setCliente($prod->getCliente());
                            $cuentaCorriente->setDescripcion("Cambio Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                            $cuentaCorriente->setEgreso($difPagado);
                            $cuentaCorriente->setIngreso(0);
                            $cuentaCorriente->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                            $cuentaCorriente->setFecha(new \DateTime('now'));
                            $em->persist($cuentaCorriente);
                            $em->persist($caja);
                            
                        }
                    }else{
                        if ($data['cant_' . $prod->getId()] != $prod->getTotal()){
                            $diferencia = $prod->getTotal() - $data['cant_' . $prod->getId()];
                            $caja->setDescripcion("Venta a ". $prod->getCliente()->getNombre() . " de " . $prod->getProducto()->getNombre());
                            $caja->setIngreso($data['cant_' . $prod->getId()]);
                            $caja->setEgreso(0);
                            
                            $cuentaCorriente = new CuentaCorriente();
                            $cuentaCorriente->setCliente($prod->getCliente());
                            $cuentaCorriente->setDescripcion("Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                            $cuentaCorriente->setEgreso(0);
                            $cuentaCorriente->setIngreso($diferencia);
                            $cuentaCorriente->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                            $cuentaCorriente->setFecha(new \DateTime('now'));
                            $em->persist($cuentaCorriente);
                            $em->persist($caja);
                        }else{
                            $caja->setDescripcion("Venta a ". $prod->getCliente()->getNombre() . " de " . $prod->getProducto()->getNombre());
                            $caja->setIngreso($data['cant_' . $prod->getId()]);
                            $caja->setEgreso(0);
                            $em->persist($caja);
                        }
                    }
                    
                }else{
                    if ($prod->getEnvio()->getCompletado()){
                       $caja->setDescripcion("Cancelacion Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                       $caja->setIngreso(0);
                       $caja->setEgreso($prod->getPagado());
                       
                       $diferencia = $prod->getTotal() - $prod->getPagado();
                       $cuentaCorriente = new CuentaCorriente();
                       $cuentaCorriente->setCliente($prod->getCliente());
                       $cuentaCorriente->setDescripcion("Cancelacion Venta a ". $prod->getCliente()->getNombre(). " de " . $prod->getProducto()->getNombre());
                       $cuentaCorriente->setEgreso($diferencia);
                       $cuentaCorriente->setIngreso(0);
                       $cuentaCorriente->setEnlace($this->generateUrl('show_envio', array('id' => $envio->getId())));
                       $cuentaCorriente->setFecha(new \DateTime('now'));
                       $em->persist($cuentaCorriente);
                       $em->persist($caja);
                       
                    }
                }
                $prod->setPagado($data['cant_' . $prod->getId()]);
                $prod->setConfirmado($data['conf_' . $prod->getId()]);
            }
            
            $em->persist($envio);            
            $em->flush();
            return $this->redirect($this->generateUrl('show_envio', array('id' => $envio->getId())));
            
        }        
            
        return array(
                "form" => $form->createView(), "entity" => $envio, "productos" => $arrayProductos
            );    
       
    }
    
     /**
     * @Route("/imprimir/{id}", name="envio_imprimir")
     * @Template()
     */
    public function imprimirAction($id)
    {
        $em = $this->get('doctrine')->getManager();
        $envio = $em->getRepository('DepoBundle:Envio')->find($id);
        $gastos = $em->getRepository('DepoBundle:Gasto')->findAll();
        $facade = $this->get('ps_pdf.facade');
        $response = new Response();
        $this->render('DepoBundle:Envio:imprimir.pdf.twig', 
                array("entity" => $envio, "gastos" => $gastos), $response);
        
        $xml = $response->getContent();
        $content = $facade->render($xml);
        
        return new Response($content, 200, array('content-type' => 'application/pdf'));
    }

}
