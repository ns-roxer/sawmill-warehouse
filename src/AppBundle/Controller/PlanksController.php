<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plank;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use Symfony\Component\HttpFoundation\Request;

class PlanksController extends FOSRestController
{
    /**
     * @param $id
     *
     * @return \AppBundle\Entity\Plank
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getPlankAction($id)
    {
        /** @var Plank $plank */
        $plank = $this->getDoctrine()
            ->getRepository('AppBundle:Plank')
            ->find($id);

        if ($plank === null) {
            throw $this->createNotFoundException('No such plank');
        }

        return $plank;
    }

    /**
     * @return \AppBundle\Entity\Plank[]|array
     */
    public function getPlanksAction()
    {
        /** @var Plank $plank */
        $planks = $this->getDoctrine()
            ->getRepository('AppBundle:Plank')
            ->findAll();

        return $planks;
    }

    /**
     * @View(statusCode=204)
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param                                           $id
     *
     * @return \FOS\RestBundle\View\View
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Security\Core\Exception\AccessDeniedException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \LogicException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function deletePlankAction(Request $request, $id)
    {
        /** @var string | null $token */
        $token = $request->query->get('token');

        if ( !$token || $token !== $this->getParameter('auth_token')) {
            throw $this->createAccessDeniedException();
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $plank = $em->getRepository('AppBundle:Plank')->find($id);

        if ($plank === null) {
            throw $this->createNotFoundException('No such plank');
        }

        $em->remove($plank);
        $em->flush();

        return $this->view([], 204);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \FOS\RestBundle\View\View
     */
    public function postPlankAction(Request $request)
    {
        /** @var string | null $token */
        $token = $request->query->get('token');

        if ( !$token || $token !== $this->getParameter('auth_token')) {
            throw $this->createAccessDeniedException();
        }
        
        $plank_fields = $request->request->all();

        $em = $this->getDoctrine()->getManager();
        $plank_obj = $em->getRepository('AppBundle:Plank')->preparePlankObject($plank_fields);

        $em->persist($plank_obj);
        $em->flush();
        $plank_obj->getId();

        return $this->view(['new_element' => '/api/planks/' . $plank_obj->getId()], Codes::HTTP_CREATED);
    }
}
