<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use RS\DepoStock\DepoBundle\Entity\CuentaCorriente;
use RS\DepoStock\DepoBundle\Form\CuentaCorrienteType;
use RS\DepoStock\DepoBundle\Entity\Caja;

/**
 * CuentaCorriente controller.
 *
 * @Route("/cuentacorriente")
 */
class CuentaCorrienteController extends Controller
{

    /**
     * Lists all CuentaCorriente entities.
     *
     * @Route("/", name="cuentacorriente")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $datatable = $this->get('depo.datatable.cuentacorriente');
        $datatable->buildDatatable();

        return array(
            'datatable' => $datatable,
        ); 
    }
    
    /**
    * Get all Post entities.
    *
    * @Route("/results", name="cuentacorriente_results")
    *
    * @return \Symfony\Component\HttpFoundation\Response
    */
   public function indexResultsAction()
   {
       $datatable = $this->get('depo.datatable.cuentacorriente');
       $datatable->buildDatatable();

       $query = $this->get('sg_datatables.query')->getQueryFrom($datatable);

       return $query->getResponse();
   }
   
    /**
     * Creates a new CuentaCorriente entity.
     *
     * @Route("/crear/cuentacorriente/{id}", name="cuentacorriente_create")
     * @Method("POST")
     * @Template("DepoBundle:CuentaCorriente:new.html.twig")
     */
    public function createAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new CuentaCorriente();
        $cliente = $em->getRepository("DepoBundle:Cliente")->find($id);
        $entity->setCliente($cliente);
        $entity->setFecha(new \DateTime("NOW"));
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            
            $em->flush();
            if ($entity->getEgreso() > 0){
                return $this->redirect($this->generateUrl('caja_cuenta_new', array('id' => $entity->getId())));
            }else{
                return $this->redirect($this->generateUrl('caja_show', array('id' => $entity->getId())));
            }
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a CuentaCorriente entity.
     *
     * @param CuentaCorriente $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CuentaCorriente $entity)
    {
        $form = $this->createForm(new CuentaCorrienteType(), $entity, array(
            'action' => $this->generateUrl('cuentacorriente_create', array('id' => $entity->getCliente()->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new CuentaCorriente entity.
     *
     * @Route("/new/{id}", name="cuentacorriente_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('DepoBundle:Cliente')->find($id);
        $entity = new CuentaCorriente();
        $entity->setCliente($cliente);
        $entity->setFecha(new \DateTime('NOW'));
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Finds and displays a CuentaCorriente entity.
     *
     * @Route("/{id}", name="cuentacorriente_show", options={"expose"=true})
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $cliente = $em->getRepository('DepoBundle:Cliente')->find($id);
        $entities = $em->getRepository('DepoBundle:CuentaCorriente')->findBy(array('cliente' => $id));
        $retornar = array(); $saldo = 0;
        foreach ($entities as $entity)
        {
            $retornar[$entity->getFecha()->getTimeStamp() . $entity->getId()]['fecha'] = $entity->getFecha();
            $retornar[$entity->getFecha()->getTimeStamp() . $entity->getId()]['ingreso'] = $entity->getIngreso();
            $retornar[$entity->getFecha()->getTimeStamp() . $entity->getId()]['egreso'] = $entity->getEgreso();
            $retornar[$entity->getFecha()->getTimeStamp() . $entity->getId()]['descripcion'] = $entity->getDescripcion();
            $retornar[$entity->getFecha()->getTimeStamp() . $entity->getId()]['url'] = $entity->getEnlace();
            $saldo = $saldo + ($entity->getIngreso() - $entity->getEgreso());
            $retornar[$entity->getFecha()->getTimeStamp() . $entity->getId()]['saldo'] = $saldo;
        }
        krsort($retornar);       
        
        return array(
            'entity'      => $retornar,
            'cliente' => $cliente
        );
    }

    /**
     * Displays a form to edit an existing CuentaCorriente entity.
     *
     * @Route("/{id}/edit", name="cuentacorriente_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:CuentaCorriente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuentaCorriente entity.');
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
    * Creates a form to edit a CuentaCorriente entity.
    *
    * @param CuentaCorriente $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CuentaCorriente $entity)
    {
        $form = $this->createForm(new CuentaCorrienteType(), $entity, array(
            'action' => $this->generateUrl('cuentacorriente_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing CuentaCorriente entity.
     *
     * @Route("/{id}", name="cuentacorriente_update")
     * @Method("PUT")
     * @Template("DepoBundle:CuentaCorriente:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:CuentaCorriente')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CuentaCorriente entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('cuentacorriente_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a CuentaCorriente entity.
     *
     * @Route("/{id}", name="cuentacorriente_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DepoBundle:CuentaCorriente')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CuentaCorriente entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('cuentacorriente'));
    }

    /**
     * Creates a form to delete a CuentaCorriente entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cuentacorriente_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
