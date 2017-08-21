<?php

namespace Pharmacie\EcommerceBundle\Controller;

use Pharmacie\MedicamentBundle\Entity\Fournisseur;
use Pharmacie\MedicamentBundle\Entity\Stock;
use Pharmacie\MedicamentBundle\Form\MedicamentType;
use Pharmacie\MedicamentBundle\Form\StockType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Pharmacie\MedicamentBundle\Entity\Medicament;

class AdminController extends Controller
{
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();

        /*$repository = $this->getDoctrine()->getRepository('MedicamentBundle:Vente');

        $ventes = $repository->findAll();*/

        
        /*
        * La date journalière doit être entre ces deux dates ;)
        */
        $dateStart = date('Y-m-d');
        $dateStart .= ' 00:00:00'; /* Heure de début */
        $dateEnd = date('Y-m-d');
        $dateEnd .= ' 23:59:59'; /* Heure de fin */

        /*
        * L ' Ajout de la requête WHERE daty BETWEEN a permit de bien filter journalièrement les ventes'
        */
        $query1 = $em->createQuery('SELECT v FROM MedicamentBundle:Vente v WHERE v.daty BETWEEN \''.$dateStart.'\' AND \''.$dateEnd.'\'');

        $queryGlobale = $em->createQuery('SELECT v FROM MedicamentBundle:Vente v');

        $ventesGlobale = $queryGlobale->getResult();

        $ventes = $query1->getResult();

        /*$application = (String)json_encode($ventesGlobale);*/

        $repository = $this->getDoctrine()->getRepository('MedicamentBundle:Medicament');

        $commandes = $repository->findByNombre(0);

        
        /*$clients = $em->getRepository('MedicamentBundle:Vente');*/
        
        $query2 = $em->createQuery('SELECT count(distinct v.personne) as nombre FROM MedicamentBundle:Vente v WHERE v.daty BETWEEN \''.$dateStart.'\' AND \''.$dateEnd.'\'');

        $clients = $query2->getResult();

        $queryClientGlobale = $em->createQuery('SELECT count(distinct v.personne) as nombre FROM MedicamentBundle:Vente v');

        $clientsGlobale = $queryClientGlobale->getResult();


        $query3 = $em->createQuery('SELECT sum(v.somme) as total FROM MedicamentBundle:Vente v WHERE v.daty BETWEEN \''.$dateStart.'\' AND \''.$dateEnd.'\'');

        $chiffreAffaire = $query3->getResult(); 


        $queryChiffreAffaire = $em->createQuery('SELECT sum(v.somme) as total FROM MedicamentBundle:Vente v');

        $chiffreAffaireGlobale = $queryChiffreAffaire->getResult();
        /*$query3 = $em->createQuery('select v from MedicamentBundle:Vente v');
        $updates = $query3->getResult();
        echo $updates;
        $updateId = array();
        $i=0;
        foreach($updates as $update)
        {
            $updateId[$i] = $update.medicament.id;
            $i++;
        }
        $query4 = $em->createQuery('SELECT m FROM MedicamentBundle:Medicament m where m.id in (:updateid)')
                    ->setParameter('updateid',$updateId);
        $medicamentUpdated = $query4->getResult();*/
        return $this->render('EcommerceBundle:Page:admin.html.twig',array(
            'venteGlobale'              => $ventesGlobale,
            'chiffreAffaireGlobale'     => $chiffreAffaireGlobale,
            'clientsGlobale'            => $clientsGlobale,
            'ventes'                    => $ventes, 
            'commandes'                 => $commandes, 
            'clients'                   => $clients,
            //'application'             => $application, 
            'chiffreAffaire'            => $chiffreAffaire));
    }

    public function userAction()
    {
        return $this->redirectToRoute('fos_user_change_password');
        //return $this->render('EcommerceBundle:Page:user.html.twig');
    }

    public function medicamentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('MedicamentBundle:Unite');
        $unites = $repository->findAll();
        $repository2 = $this->getDoctrine()->getRepository('MedicamentBundle:Sorte');
        $sortes = $repository2->findAll();
        $repository3 = $this->getDoctrine()->getRepository('MedicamentBundle:Medicament');
        $medicaments = $repository3->findAll();

        $medicament = new Medicament();
        $form = $this->createForm(MedicamentType::class, $medicament);
        //$form->setData($medicament);
        $form->handleRequest($request);
        $stock = new Stock();
        $form2 = $this->createForm(StockType::class, $stock);
        $form2->handleRequest($request);
        if ($form->isValid()) {
            $medicament = $form->getData();
            $medicament->uploadProfilePicture();
            $em->persist($medicament);
            $em->flush();
            return $this->redirectToRoute('ecommerce_control_medicament');
        }
        if ($form2->isValid()) {
            $stock = $form2->getData();
            $medoc=$repository3->findOneBy(array('id'=>$stock->getMedicament()->getId()));
            $medoc->setNombre($medoc->getNombre()+$stock->getNombre());
            $em->persist($stock);
            $em->persist($medoc);
            $em->flush();
            return $this->redirectToRoute('ecommerce_control_medicament');
        }
        return $this->render('EcommerceBundle:Page:medicament.html.twig', array('unites' => $unites, 'sortes' => $sortes, 'form' => $form->createView(), 'medicaments' => $medicaments, 'form2' => $form2->createView()));
    }

    public function addMedicamentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repositoryUnite = $this->getDoctrine()->getRepository('MedicamentBundle:Unite');
        $repositorySorte = $this->getDoctrine()->getRepository('MedicamentBundle:Sorte');
        $unite = $request->request->get('unite');
        $sorte = $request->request->get('sorte');
        $prix = $request->request->get('prix');
        $libelle = $request->request->get('nom');
        $file = $request->request->get('image');
        $dose = $request->request->get('dose');
        $nombre = $request->request->get('nombre');
        $medicament = new Medicament();
        $medicament->setLibelle($libelle);
        $medicament->setDose($dose);
        $medicament->setNombre($nombre);
        $medicament->setUnite($repositoryUnite->findOneBy(array('id' => $unite)));
        $medicament->setSorte($repositorySorte->findOneBy(array('id' => $sorte)));
        $medicament->setPrix($prix);
        $medicament->setFile($file);
        //echo $medicament->getFile()->getClientOriginalName();
        $medicament->uploadProfilePicture();
        $em->persist($medicament);
        $em->flush();

        return $this->redirectToRoute('ecommerce_control_medicament');
    }

    public function fournisseurAction()
    {
        $repository = $this->getDoctrine()->getRepository('MedicamentBundle:Fournisseur');
        $fournisseurs = $repository->findAll();
        return $this->render('EcommerceBundle:Page:fournisseur.html.twig', array('fournisseurs' => $fournisseurs));
    }

    public function addFournisseurAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $numero = $request->request->get('numero');
        $libelle = $request->request->get('libelle');
        $fournisseur = new Fournisseur();
        $fournisseur->setLibelle($libelle);
        $fournisseur->setNumero($numero);
        $em->persist($fournisseur);
        $em->flush();
        var_dump($fournisseur);
        return $this->redirectToRoute('ecommerce_control_fournisseur');
    }

    public function deleteFournisseurAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repository = $this->getDoctrine()->getRepository('MedicamentBundle:Fournisseur');
        $fournisseur = $repository->find($id);
        $em->remove($fournisseur);
        $em->flush();
        return $this->redirectToRoute('ecommerce_control_fournisseur');
    }
}
