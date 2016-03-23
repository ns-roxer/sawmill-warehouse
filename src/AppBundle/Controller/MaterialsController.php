<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Material;
use Doctrine\ORM\EntityManager;
use FOS\RestBundle\Controller\Annotations\View;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class MaterialsController extends FOSRestController
{
    /**
     * @param $id
     *
     * @return \AppBundle\Entity\Material
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function getMaterialAction($id)
    {
        /** @var Material $material */
        $material = $this->getDoctrine()
            ->getRepository('AppBundle:Material')
            ->find($id);

        if ($material === null) {
            throw $this->createNotFoundException('No such material');
        }

        return $material;
    }

    /**
     * @return \AppBundle\Entity\Material[]|array
     */
    public function getMaterialsAction()
    {
        /** @var Material[] $materials */
        $materials = $this->getDoctrine()
            ->getRepository('AppBundle:Material')
            ->findAll();

        return $materials;
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
        $material = $em->getRepository('AppBundle:Material')->find($id);

        if ($material === null) {
            throw $this->createNotFoundException('No such material');
        }

        $em->remove($material);
        $em->flush();

        return $this->view([], 204);
    }
}
