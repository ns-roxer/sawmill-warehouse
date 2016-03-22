<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class MaterialsController extends FOSRestController
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }
}
