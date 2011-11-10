<?php

namespace YCDN\PartnersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use YCDN\PartnersBundle\Entity\Partner;
use YCDN\PartnersBundle\Form\PartnerType;

/**
 * Partner controller.
 *
 * @Route("/partner")
 */
class PartnerController extends Controller
{
    /**
     * Lists all Partner entities.
     *
     * @Route("/", name="partner")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('YCDNPartnersBundle:Partner')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Partner entity.
     *
     * @Route("/{id}/show", name="partner_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('YCDNPartnersBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Partner entity.
     *
     * @Route("/new", name="partner_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Partner();
        $form   = $this->createForm(new PartnerType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Partner entity.
     *
     * @Route("/create", name="partner_create")
     * @Method("post")
     * @Template("YCDNPartnersBundle:Partner:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Partner();
        $request = $this->getRequest();
        $form    = $this->createForm(new PartnerType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            
            $entity->upload();
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partner_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Partner entity.
     *
     * @Route("/{id}/edit", name="partner_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('YCDNPartnersBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $editForm = $this->createForm(new PartnerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Partner entity.
     *
     * @Route("/{id}/update", name="partner_update")
     * @Method("post")
     * @Template("YCDNPartnersBundle:Partner:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('YCDNPartnersBundle:Partner')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Partner entity.');
        }

        $editForm   = $this->createForm(new PartnerType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('partner_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Partner entity.
     *
     * @Route("/{id}/delete", name="partner_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('YCDNPartnersBundle:Partner')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Partner entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('partner'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
