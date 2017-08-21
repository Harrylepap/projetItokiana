<?php
namespace Pharmacie\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Pharmacie\MedicamentBundle\Entity\Fournisseur;
use Pharmacie\MedicamentBundle\Entity\Stock;
use Pharmacie\MedicamentBundle\Form\MedicamentType;
use Pharmacie\MedicamentBundle\Form\StockType;
use Symfony\Component\HttpFoundation\Session\Session;
use Pharmacie\MedicamentBundle\Entity\Medicament;

class DefaultController extends Controller
{
	

    public function indexAction()
    {
    	return $this->redirectToRoute("fos_user_change_password");
    }

    private function recuperer_compte() 
    {
        $em = $this->getDoctrine()->getManager();

        $pseudo_utilisateur = $this->get('security.token_storage')->getToken()->getUser();

        $requete_selection_utilisateur = $em->createQuery(
    			"SELECT v FROM UtilisateurBundle:Utilisateur v WHERE v.username = '".$pseudo_utilisateur."'"
    		);

    	return $utilisateur = $requete_selection_utilisateur->getResult();
    }

    public function changerAction(Request $request) 
    {
    	$ancien_password = $request->request->get('ancien_password');
    	$nouveau_password = $request->request->get('nouveau_password');
    	/*
    	*	$confirmation_password = $request->request->get('confirmation_password');
    	*/

    	if($this->comparer_password($ancien_password)) 
    	{
    		/*
    		* Mise a jour de la base de données
    		*/
    	}

    	$utilisateur = $this->recuperer_compte();

    	return $this->render('UtilisateurBundle:Default:profil.html.twig',
        	array('users'=> $utilisateur)
        );
    }

    private function prendre_password() 
    {

    	$pseudo_utilisateur = $this->container->get('security.token_storage')->getToken()->getUser();
    	
    	$utilisateur = $this->recuperer_compte($pseudo_utilisateur);

    	$password = $utilisateur[0]->getPassword();

    	return $password;
    }

    private function comparer_password($password_a_comparer) 
    {
    	//$utilisateur = new AppBundle\Entity\Utilisateur();

    	//$password_de_la_base = $this->prendre_password();

    	//$encoder = $this->container->get('security.password_encoder');

    	//$password_encoder = $encoder->encodePassword($utilisateur,$password_a_comparer);

    	$password_encoder = $this->bcrypt($password_a_comparer);
    	
    	echo $password_encoder;

    	/*
    	* Le cryptage du mot de passe saisi par l'utilisateur est nécessaire
    	*/
    	if ($password_de_la_base === $password_encoder) 
    	{
    		return true;
    	}

    	return false;
    }
}