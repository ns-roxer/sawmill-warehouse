<?php

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class PlanksController extends FOSRestController
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \InvalidArgumentException
     */
    public function getPlankAction($id)
    {

        return ['hello' => 'world'];
    }

    public function getPlanksAction()
    {

        return ['yes'];
    }
}
