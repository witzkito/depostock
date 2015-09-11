<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use RS\DepoStock\DepoBundle\Entity\Ingreso;
use RS\DepoStock\DepoBundle\Form\IngresoType;

/**
 * Ingreso controller.
 *
 * @Route("/ingreso")
 */
class IngresoController extends Controller
{

    /**
     * Lists all Ingreso entities.
     *
     * @Route("/", name="ingreso")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DepoBundle:Ingreso')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Ingreso entity.
     *
     * @Route("/nuevo/{id}", name="ingreso_deposito")
     * @Template("DepoBundle:Ingreso:new.html.twig")
     */
    public function createAction($id, Request $request)
    {
        $entity = new Ingreso();
        $em = $this->get('doctrine')->getManager();
        $deposito = $em->getRepository("DepoBundle:Deposito")->find($id);
        $entity->setDeposito($deposito);
        $entity->setFecha(new \DateTime('NOW'));
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('ingreso_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Ingreso entity.
     *
     * @param Ingreso $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Ingreso $entity)
    {
        $form = $this->createForm(new IngresoType(), $entity, array(
            'action' => $this->generateUrl('ingreso_deposito', array('id' => $entity->getDeposito()->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Ingresar'));

        return $form;
    }

    /**
     * Displays a form to create a new Ingreso entity.
     *
     * @Route("/new", name="ingreso_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Ingreso();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Ingreso entity.
     *
     * @Route("/{id}", name="ingreso_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Ingreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingreso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Ingreso entity.
     *
     * @Route("/{id}/edit", name="ingreso_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Ingreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingreso entity.');
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
    * Creates a form to edit a Ingreso entity.
    *
    * @param Ingreso $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Ingreso $entity)
    {
        $form = $this->createForm(new IngresoType(), $entity, array(
            'action' => $this->generateUrl('ingreso_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    /**
     * Edits an existing Ingreso entity.
     *
     * @Route("/{id}", name="ingreso_update")
     * @Method("PUT")
     * @Template("DepoBundle:Ingreso:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Ingreso')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ingreso entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('ingreso_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Ingreso entity.
     *
     * @Route("/{id}", name="ingreso_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DepoBundle:Ingreso')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Ingreso entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('depo_homepage'));
    }

    /**
     * Creates a form to delete a Ingreso entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('ingreso_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar', 'attr' => array("class" => "btn btn-danger")))
            ->getForm()
        ;
    }
}
