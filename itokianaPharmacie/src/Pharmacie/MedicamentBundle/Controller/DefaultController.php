<?php

namespace Pharmacie\MedicamentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MedicamentBundle:Default:index.html.twig');
    }
}
