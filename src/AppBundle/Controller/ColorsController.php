<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ColorsController extends FOSRestController
{
    public function getColorsAction(Request $request)
    {
        return [$request->query->all()];
    }
}
