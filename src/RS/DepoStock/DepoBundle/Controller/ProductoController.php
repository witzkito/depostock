<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use RS\DepoStock\DepoBundle\Entity\Producto;
use RS\DepoStock\DepoBundle\Form\ProductoType;

/**
 * Producto controller.
 *
 * @Route("/producto")
 */
class ProductoController extends Controller
{

    /**
     * Lists all Producto entities.
     *
     * @Route("/", name="producto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $datatable = $this->get('depo.datatable.producto');
        $datatable->buildDatatable();

        return array(
            'datatable' => $datatable,
        );  
    }
    
    /**
    * Get all Post entities.
    *
    * @Route("/results", name="producto_results")
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function indexResultsAction()
   {
       $datatable = $this->get('depo.datatable.producto');
       $datatable->buildDatatable();

       $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

       return $query->getResponse();
   }
   
    /**
     * Creates a new Producto entity.
     *
     * @Route("/", name="producto_create")
     * @Method("POST")
     * @Template("DepoBundle:Producto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Producto();
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $userDeposito = $em->getRepository('DepoBundle:UsuarioDeposito')->findOneBy(array('usuario' => $user->getId())); 
        $entity->setEmpresa($userDeposito->getDeposito()->getEmpresa());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if ($entity->getFotoProducto() != null)
            {
                $entity->getFotoProducto()->setProducto($entity);
                $entity->getFotoProducto()->upload();
            }
            $em->persist($entity);
            
            $em->flush();

            $this->redirect($this->generateUrl('producto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Producto entity.
     *
     * @param Producto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Producto entity.
     *
     * @Route("/new", name="producto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Producto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Producto entity.
     *
     * @Route("/{id}", name="producto_show", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Producto entity.
     *
     * @Route("/{id}/edit", name="producto_edit", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
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
    * Creates a form to edit a Producto entity.
    *
    * @param Producto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Producto $entity)
    {
        $form = $this->createForm(new ProductoType(), $entity, array(
            'action' => $this->generateUrl('producto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    /**
     * Edits an existing Producto entity.
     *
     * @Route("/{id}", name="producto_update")
     * @Method("PUT")
     * @Template("DepoBundle:Producto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Producto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Producto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            if ($entity->getFotoProducto() != null)
            {
                $entity->getFotoProducto()->setProducto($entity);
                $entity->getFotoProducto()->upload();
            }
            $em->flush();

            return $this->redirect($this->generateUrl('producto', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Producto entity.
     *
     * @Route("/{id}", name="producto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DepoBundle:Producto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Producto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('producto'));
    }

    /**
     * Creates a form to delete a Producto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar', 'attr' => array("class" => "btn btn-danger")))
            ->getForm()
        ;
    }
    
    /**
     * Lists all Producto entities.
     *
     * @Route("/list/{id}/{idDeposito}", name="list_producto")
     * @Method("GET")
     * @Template()
     */
    public function listAction($id, $idDeposito)
    {
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('DepoBundle:Producto')->find($id);
        $deposito = $em->getRepository('DepoBundle:Deposito')->find($idDeposito);
        $retornar = array();
        $stock = 0;
            foreach ($producto->getIngresos() as $ingreso)
            {
                if ($ingreso->isDeposito($idDeposito)){
                    $retornar[$ingreso->getIngreso()->getFecha()->getTimeStamp()]['fecha'] = $ingreso->getIngreso()->getFecha();
                    $retornar[$ingreso->getIngreso()->getFecha()->getTimeStamp()]['cliente'] = $ingreso->getIngreso()->getTransporte();
                    $retornar[$ingreso->getIngreso()->getFecha()->getTimeStamp()]['entrada'] = $ingreso->getCantidad();
                    $retornar[$ingreso->getIngreso()->getFecha()->getTimeStamp()]['salida'] = "";
                    $stock = $stock + ($ingreso->getCantidad());
                    $retornar[$ingreso->getIngreso()->getFecha()->getTimeStamp()]['stock'] = $stock;
                }
            }
            foreach ($producto->getEnvios() as $envio)
            {
                if ($envio->isDeposito($idDeposito)){
                    $retornar[$envio->getEnvio()->getFecha()->getTimeStamp()]['fecha'] = $envio->getEnvio()->getFecha();
                    $retornar[$envio->getEnvio()->getFecha()->getTimeStamp()]['cliente'] = $envio->getCliente();
                    $retornar[$envio->getEnvio()->getFecha()->getTimeStamp()]['entrada'] = "";
                    $retornar[$envio->getEnvio()->getFecha()->getTimeStamp()]['salida'] = $envio->getCantidad();
                    $stock = $stock - ($envio->getCantidad());
                    $retornar[$envio->getEnvio()->getFecha()->getTimeStamp()]['stock'] = $stock;
                }
            }
            krsort($retornar);

        return array(
            'entities' => $retornar, 'entity' => $producto, 'deposito' => $deposito->getNombre()
        );
    }
}
