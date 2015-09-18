<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use RS\DepoStock\DepoBundle\Entity\Caja;
use RS\DepoStock\DepoBundle\Form\CajaType;

/**
 * Caja controller.
 *
 * @Route("/caja")
 */
class CajaController extends Controller
{

    /**
     * Lists all Caja entities.
     *
     * @Route("/{id}", name="caja")
     * @Method("GET")
     * @Template()
     */
    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DepoBundle:Caja')->findBy(array('deposito' => $id));
        $deposito = $em->getRepository('DepoBundle:Deposito')->find($id);
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
            'entities' => $retornar, 'deposito' => $deposito
        );
    }
    /**
     * Creates a new Caja entity.
     *
     * @Route("/nuevo/{id}", name="caja_create")
     * @Template("DepoBundle:Caja:new.html.twig")
     */
    public function createAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();            
        $entity = new Caja();
        $entity->setFecha(new \DateTime('now'));
        $deposito = $em->getRepository("DepoBundle:Deposito")->find($id);
        $form = $this->createCreateForm($entity, $deposito);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setDeposito($deposito);
            $em->persist($entity);
            $em->flush();
            $entity->setEnlace($this->generateUrl('caja_show', array('id' => $entity->getId())));
            $em->persist($entity);
            $em->flush();
            return $this->redirect($this->generateUrl('caja_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'deposito' => $deposito
        );
    }

    /**
     * Creates a form to create a Caja entity.
     *
     * @param Caja $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Caja $entity, $deposito)
    {
        $form = $this->createForm(new CajaType(), $entity, array(
            'action' => $this->generateUrl('caja_create', array("id" => $deposito->getId())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }

    /**
     * Displays a form to create a new Caja entity.
     *
     * @Route("/new/{id}", name="caja_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $deposito = $em->getRepository('DepoBundle:Deposito')->find($id);
        
        $entity = new Caja();
        $entity->setDeposito($deposito);
        $entity->setFecha(new \DateTime());
        $form   = $this->createCreateForm($entity, $deposito);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'deposito' => $deposito,
        );
    }

    /**
     * Finds and displays a Caja entity.
     *
     * @Route("/mostrar/{id}", name="caja_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Caja')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caja entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Caja entity.
     *
     * @Route("/{id}/edit", name="caja_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Caja')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caja entity.');
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
    * Creates a form to edit a Caja entity.
    *
    * @param Caja $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Caja $entity)
    {
        $form = $this->createForm(new CajaType(), $entity, array(
            'action' => $this->generateUrl('caja_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    /**
     * Edits an existing Caja entity.
     *
     * @Route("/{id}", name="caja_update")
     * @Method("PUT")
     * @Template("DepoBundle:Caja:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DepoBundle:Caja')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Caja entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('caja_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Caja entity.
     *
     * @Route("/{id}", name="caja_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DepoBundle:Caja')->find($id);
            $deposito = $entity->getDeposito();
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Caja entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('caja', array('id' => $deposito->getId())));
    }

    /**
     * Creates a form to delete a Caja entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('caja_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Borrar', 'attr' => array("class" => "btn btn-danger")))
            ->getForm()
        ;
    }
}
