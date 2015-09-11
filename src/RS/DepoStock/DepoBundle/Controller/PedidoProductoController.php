<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use RS\DepoStock\DepoBundle\Entity\PedidoProducto;
use RS\DepoStock\DepoBundle\Form\PedidoProductoType;

/**
 * PedidoProducto controller.
 *
 * @Route("/pedidoproducto")
 */
class PedidoProductoController extends Controller
{

    /**
     * Lists all PedidoProducto entities.
     *
     * @Route("/", name="pedidoproducto")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DepoBundle:PedidoProducto')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new PedidoProducto entity.
     *
     * @Route("/", name="pedidoproducto_create")
     * @Method("POST")
     * @Template("DepoBundle:PedidoProducto:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new PedidoProducto();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('pedidoproducto_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a PedidoProducto entity.
     *
     * @param PedidoProducto $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(PedidoProducto $entity)
    {
        $form = $this->createForm(new PedidoProductoType(), $entity, array(
            'action' => $this->generateUrl('pedidoproducto_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PedidoProducto entity.
     *
     * @Route("/new", name="pedidoproducto_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new PedidoProducto();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a PedidoProducto entity.
     *
     * @Route("/{id}", name="pedidoproducto_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:PedidoProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing PedidoProducto entity.
     *
     * @Route("/{id}/edit", name="pedidoproducto_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:PedidoProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoProducto entity.');
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
    * Creates a form to edit a PedidoProducto entity.
    *
    * @param PedidoProducto $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PedidoProducto $entity)
    {
        $form = $this->createForm(new PedidoProductoType(), $entity, array(
            'action' => $this->generateUrl('pedidoproducto_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PedidoProducto entity.
     *
     * @Route("/{id}", name="pedidoproducto_update")
     * @Method("PUT")
     * @Template("DepoBundle:PedidoProducto:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:PedidoProducto')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PedidoProducto entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('pedidoproducto_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a PedidoProducto entity.
     *
     * @Route("/{id}", name="pedidoproducto_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DepoBundle:PedidoProducto')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PedidoProducto entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('pedidoproducto'));
    }

    /**
     * Creates a form to delete a PedidoProducto entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('pedidoproducto_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
