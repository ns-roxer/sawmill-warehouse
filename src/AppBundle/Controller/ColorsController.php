<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Color;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class ColorsController extends FOSRestController
{
    /**
     * @param $id
     *
     * @return \AppBundle\Entity\Color
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getColorAction($id)
    {
        /** @var Color $color */
        $color = $this->getDoctrine()
            ->getRepository('AppBundle:Material')
            ->find($id);

        if ($color === null) {
            throw $this->createNotFoundException('No such color');
        }

        return $color;
    }

    /**
     * @return \AppBundle\Entity\Material[]|array
     */
    public function getColorsAction()
    {
        /** @var Color[] $colors */
        $colors = $this->getDoctrine()
            ->getRepository('AppBundle:Color')
            ->findAll();

        return $colors;
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
    public function deleteColorAction(Request $request, $id)
    {
        /** @var string | null $token */
        $token = $request->query->get('token');

        if ( !$token || $token !== $this->getParameter('auth_token')) {
            throw $this->createAccessDeniedException();
        }

        /** @var EntityManager $em */
        $em = $this->getDoctrine()->getManager();
        $color = $em->getRepository('AppBundle:Color')->find($id);

        if ($color === null) {
            throw $this->createNotFoundException('No such color');
        }

        $em->remove($color);
        $em->flush();

        return $this->view([], 204);
    }
}
