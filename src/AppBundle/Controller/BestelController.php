<?php
//Namespace en uses, mag je vergeten. Moet er wel in staan!
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Bestellen;
use AppBundle\Form\Type\BestellenType;

class BestelController extends Controller
{	
	/**
     * @Route("/bestelorder/nieuw", name="nieuwbestelorder")
     */
    public function nieuwBestelorder(Request $request) {
		$nieuwBestelorder = new Bestellen();
		$form = $this->createForm(BestellenType::class, $nieuwBestelorder);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($nieuwBestelorder);
			$em->flush();
			return $this->redirect($this->generateurl("bestelorderoverzicht"));
		}

		return new Response($this->render('form.html.twig', array('form' => $form->createView())));
    }

	/**
     * @Route("/bestelorder/wijzig/{id}", name="bestelorderwijzigen")
     */
    public function wijzigBestelorder(Request $request, $id) {
		$bestaandBestelorder = $this->getDoctrine()->getRepository("AppBundle:Bestellen")->find($id);
		$form = $this->createForm(BestellenType::class, $bestaandBestelorder);

		$form->handleRequest($request);
		if ($form->isSubmitted() && $form->isValid()) {
			$em = $this->getDoctrine()->getManager();
			$em->persist($bestaandBestelorder);
			$em->flush();
			return $this->redirect($this->generateurl("bestelorderoverzicht"));
		}

		return new Response($this->render('form.html.twig', array('form' => $form->createView())));
    }

	/**
     * @Route("/bestelorder/verwijder/{id}", name="bestelorderverwijderen")
     */
    public function verwijderBestelorder(Request $request, $id) {
    	$em = $this->getDoctrine()->getManager();
		$bestaandBestelorder = $em->getRepository("AppBundle:Bestellen")->find($id);
		$em->remove($bestaandBestelorder);
		$em->flush();
		return $this->redirect($this->generateurl("bestelorderoverzicht"));
    }


	/**
     * @Route("/bestelorders", name="bestelorderoverzicht")
     */
    public function alleBestelorders(Request $request) {
	  $Bestelorders = $this->getDoctrine()->getRepository("AppBundle:Bestellen")->findAll();
      return new Response($this->render('bestellen.html.twig', array('bestelorders' => $Bestelorders)));
    }
}
?>