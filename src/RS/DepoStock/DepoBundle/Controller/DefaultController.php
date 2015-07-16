<?php

namespace RS\DepoStock\DepoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DepoBundle:Default:index.html.twig', array('name' => $name));
    }
}
