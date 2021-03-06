<?php

namespace WCS\CoavBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use WCS\CoavBundle\Entity\Flight;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;


/**
 * Flight controller.
 *
 * @Route("flight")
 */
class FlightController extends Controller
{
    /**
     * Lists all flight entities.
     *
     * @Route("/", name="flight_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $url = $request->getPathInfo();
        $path = (trim($url, "/"));
        $criteria = '';
        if ($path == "flight") {
            $criteria = null;
        } else {
            $criteria = null;
        }

        $flights = $em->getRepository('WCSCoavBundle:Flight')->findBy(['user'   => $criteria]);

        $api = $this->container->get('api.connect');
        $api->getConnexion();

        /**envoi email test
        $message = \Swift_Message::newInstance()
            -> setSubject('test email')
            ->setFrom('severinelab@gmail.com')
            ->setTo('severinelab@gmail.com')
            ->setCharset('utf-8')
            ->setContentType('text/html')
            ->setBody('Coucou ceci est un test');
        $this->get('mailer')->send($message); */

        return $this->render('flight/index.html.twig', array(
            'flights' => $flights,
        ));
    }

    /**
     * @Route("/search-terrain", name="search_terrain", defaults={"_format"="json"})
     * @Method("GET")
     */
    public function searchTerrainAction(Request $request)
    {
        $q = $request->query->get('term');
        $results = $this->getDoctrine()->getRepository('WCS\CoavBundle:Airport')->findLike($q);

        return $this->render(":default/search.json.twig", ['terrains' => $results]);
    }

    /**
     * Creates a new flight entity.
     *
     * @Route("/new", name="flight_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_PILOT')")
     */
    public function newAction(Request $request)
    {
        $flight = new Flight();
        $form = $this->createForm('WCS\CoavBundle\Form\FlightType', $flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($flight);
            $em->flush();

            return $this->redirectToRoute('flight_show', array('id' => $flight->getId()));
        }

        return $this->render('flight/new.html.twig', array(
            'flight' => $flight,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a flight entity.
     *
     * @Route("/{id}", name="flight_show")
     * @Method("GET")
     */
    public function showAction(Flight $flight)
    {
        $deleteForm = $this->createDeleteForm($flight);

        return $this->render('flight/show.html.twig', array(
            'flight' => $flight,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing flight entity.
     *
     * @Route("/{id}/edit", name="flight_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_PILOT')")
     */
    public function editAction(Request $request, Flight $flight)
    {
        $deleteForm = $this->createDeleteForm($flight);
        $editForm = $this->createForm('WCS\CoavBundle\Form\FlightType', $flight);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flight_edit', array('id' => $flight->getId()));
        }

        return $this->render('flight/edit.html.twig', array(
            'flight' => $flight,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a flight entity.
     *
     * @Route("/{id}", name="flight_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Flight $flight)
    {
        $form = $this->createDeleteForm($flight);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($flight);
            $em->flush();
        }

        return $this->redirectToRoute('flight_index');
    }

    /**
     * Creates a form to delete a flight entity.
     *
     * @param Flight $flight The flight entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Flight $flight)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('flight_delete', array('id' => $flight->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
