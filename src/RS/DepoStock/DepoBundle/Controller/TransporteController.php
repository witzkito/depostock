<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use RS\DepoStock\DepoBundle\Entity\Transporte;
use RS\DepoStock\DepoBundle\Form\TransporteType;

/**
 * Transporte controller.
 *
 * @Route("/transporte")
 */
class TransporteController extends Controller
{

    /**
     * Lists all Transporte entities.
     *
     * @Route("/", name="transporte")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->container->get('security.context')->getToken()->getUser();
        $userDeposito = $em->getRepository('DepoBundle:UsuarioDeposito')->findOneBy(array('usuario' => $user->getId())); 
        $entities = $userDeposito->getDeposito()->getEmpresa()->getTransportes();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Transporte entity.
     *
     * @Route("/", name="transporte_create")
     * @Method("POST")
     * @Template("DepoBundle:Transporte:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = new Transporte();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $userDeposito = $em->getRepository('DepoBundle:UsuarioDeposito')->findOneBy(array('usuario' => $user->getId())); 
        $entity->setEmpresa($userDeposito->getDeposito()->getEmpresa());
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('transporte_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Transporte entity.
     *
     * @param Transporte $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Transporte $entity)
    {
        $form = $this->createForm(new TransporteType(), $entity, array(
            'action' => $this->generateUrl('transporte_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Transporte entity.
     *
     * @Route("/new", name="transporte_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Transporte();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Transporte entity.
     *
     * @Route("/{id}", name="transporte_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Transporte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transporte entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Transporte entity.
     *
     * @Route("/{id}/edit", name="transporte_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Transporte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transporte entity.');
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
    * Creates a form to edit a Transporte entity.
    *
    * @param Transporte $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Transporte $entity)
    {
        $form = $this->createForm(new TransporteType(), $entity, array(
            'action' => $this->generateUrl('transporte_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    /**
     * Edits an existing Transporte entity.
     *
     * @Route("/{id}", name="transporte_update")
     * @Method("PUT")
     * @Template("DepoBundle:Transporte:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Transporte')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Transporte entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('transporte_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Transporte entity.
     *
     * @Route("/{id}", name="transporte_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DepoBundle:Transporte')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Transporte entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('transporte'));
    }

    /**
     * Creates a form to delete a Transporte entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('transporte_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar', 'attr' => array('class' => 'btn btn-danger')))
            ->getForm()
        ;
    }
}
