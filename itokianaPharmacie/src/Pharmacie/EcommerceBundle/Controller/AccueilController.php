<?php

namespace Pharmacie\EcommerceBundle\Controller;

use Pharmacie\MedicamentBundle\Entity\Vente;
use Pharmacie\MedicamentBundle\Entity\Medicament;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class AccueilController extends Controller
{
    public function indexAction()
    {
        $repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('MedicamentBundle:Medicament')
        ;

        $medicaments = $repository->findAll();
        return $this->render('EcommerceBundle:Page:index.html.twig',array('medicaments'=>$medicaments));
    }
    public function vitrineAction()
    {
        return $this->render('EcommerceBundle:Page:Vitrine.html.twig');
    }
    public function  addPanierAction(Request $request,$id)
    {
        $session = $request->getSession();
        $panier = $session->get('panier');
        $taille = count($panier);
        $panier[$taille] = $id;
        $session->set('panier',$panier);
        $request->getSession()
            ->getFlashBag()
            ->add('success', 'médicament ajouté avec succès au panier')
        ;
        return $this->redirectToRoute("ecommerce_homepage");
    }
    public function panierAction(Request $request)
    {
        $session = $request->getSession();
		$medicaments = array();
		if($session->get('panier') !== null)
		{
			$panier = $session->get('panier');
			$repository = $this->getDoctrine()->getRepository('MedicamentBundle:Medicament');
			foreach ($panier as $id)
			{
				$medicament = $repository->findOneById($id);
				array_push($medicaments, $medicament);
			}
		}
        return $this->render('EcommerceBundle:Page:panier.html.twig',array('medicaments' => $medicaments));
    }

    public function validerPanierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $session = $request->getSession();
        $panier = $session->get('panier');
        $acheteur = $request->request->get('acheteur');
        $nombres = array();
        for($i=0; $i<count($panier); $i++)
        {
            $nombres[$i] = $request->request->get('nombre'.$i);
        }
        $user = $this->get('security.token_storage')->getToken()->getUser();
        for($i=0; $i<count($panier); $i++)
        {
            $medicament = $em->getRepository('MedicamentBundle:Medicament')->findOneBy(array('id' => $panier[$i]));
            $vente = new Vente($acheteur, $user, $medicament, $nombres[$i]);
            $nombreMedicamentActuel = $medicament->getNombre();
            if($medicament->getNombre() >= $nombres[$i])
            {
                if($nombres[$i]!=0)
                {
                    $em->persist($vente);
                    $medicament->setNombre($nombreMedicamentActuel - $nombres[$i]);
                }
            }
            else{
                $request->getSession()
                    ->getFlashBag()
                    ->add('danger', "Il n'y a plus que ".$medicament->getNombre()." ".$medicament->getLibelle())
                ;
                return $this->redirectToRoute("ecommerce_panier");
            }
        }
        $em->persist($medicament);
        $em->flush();
        $session->set('panier',array());
        $request->getSession()
            ->getFlashBag()
            ->add('success', "Vente effectuée avec succès")
        ;
        return $this->redirectToRoute("ecommerce_panier");
    }

    public function historiqueAction()
    {
        $repository = $this->getDoctrine()->getRepository('MedicamentBundle:Vente');
        $ventes = $repository->findAll();
        return $this->render('EcommerceBundle:Page:historique.html.twig',array('ventes' => $ventes));
    }

    public function commandeAction()
    {
        $repository = $this->getDoctrine()->getRepository('MedicamentBundle:Medicament');
        $commandes = $repository->findByNombre(0);
        return $this->render('EcommerceBundle:Page:commande.html.twig',array('commandes' => $commandes));
    }

    public function rechercheAction(Request $request)
    {
        $mot=$request->request->get("mot");
        /*$repository = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('MedicamentBundle:Medicament')
        ;
        $medicaments = $repository->findBy(array("libelle"=>$mot));*/
        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'select m from MedicamentBundle:Medicament m where m.libelle LIKE :mot'
        )
            ->setParameter('mot','%'.$mot.'%');

        $medicaments = $query->getResult();
        return $this->render('EcommerceBundle:Page:index.html.twig',array('medicaments'=>$medicaments));
    }
}
