<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Jurisdiccion;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Jurisdiccion controller.
 *
 * @Route("jurisdiccion")
 */
class JurisdiccionController extends Controller
{
    /**
     * Lists all jurisdiccion entities.
     *
     * @Route("/", name="jurisdiccion_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $jurisdiccions = $em->getRepository('AppBundle:Jurisdiccion')->findAll();

        return $this->render('jurisdiccion/index.html.twig', array(
            'jurisdiccions' => $jurisdiccions,
        ));
    }

    /**
     * Creates a new jurisdiccion entity.
     *
     * @Route("/new", name="jurisdiccion_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $jurisdiccion = new Jurisdiccion();
        $form = $this->createForm('AppBundle\Form\JurisdiccionType', $jurisdiccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($jurisdiccion);
            $em->flush($jurisdiccion);

            $this->addFlash(
               'success',
               'Los datos fueron guardados correctamente.'
             );

            return $this->redirectToRoute('jurisdiccion_show', array('id' => $jurisdiccion->getId()));
        }

        return $this->render('jurisdiccion/new.html.twig', array(
            'jurisdiccion' => $jurisdiccion,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a jurisdiccion entity.
     *
     * @Route("/{id}", name="jurisdiccion_show")
     * @Method("GET")
     */
    public function showAction(Jurisdiccion $jurisdiccion)
    {
        $deleteForm = $this->createDeleteForm($jurisdiccion);

        return $this->render('jurisdiccion/show.html.twig', array(
            'jurisdiccion' => $jurisdiccion,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing jurisdiccion entity.
     *
     * @Route("/{id}/edit", name="jurisdiccion_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Jurisdiccion $jurisdiccion)
    {
        $deleteForm = $this->createDeleteForm($jurisdiccion);
        $editForm = $this->createForm('AppBundle\Form\JurisdiccionType', $jurisdiccion);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
               'success',
               'Los datos fueron guardados correctamente.'
             );

            return $this->redirectToRoute('jurisdiccion_edit', array('id' => $jurisdiccion->getId()));
        }

        return $this->render('jurisdiccion/edit.html.twig', array(
            'jurisdiccion' => $jurisdiccion,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a jurisdiccion entity.
     *
     * @Route("/{id}", name="jurisdiccion_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Jurisdiccion $jurisdiccion)
    {
        $form = $this->createDeleteForm($jurisdiccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($jurisdiccion);
            $em->flush($jurisdiccion);
        }

        return $this->redirectToRoute('jurisdiccion_index');
    }

    /**
     * Creates a form to delete a jurisdiccion entity.
     *
     * @param Jurisdiccion $jurisdiccion The jurisdiccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Jurisdiccion $jurisdiccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jurisdiccion_delete', array('id' => $jurisdiccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
