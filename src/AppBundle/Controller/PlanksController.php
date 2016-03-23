<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Plank;
use Doctrine\ORM\EntityManager;
use Elasticsearch\ClientBuilder;
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
    public function getPlanksAction(Request $request)
    {
        $planks = [];
        $search_query = $request->query->all();

        if (count($search_query) > 0) {
            $client = ClientBuilder::create()->build();
            $params['index'] = 'plank';
            $params['type'] = 'plank';
            foreach ($search_query as $keyword => $term) {
                $params['body']['query']['match'][$keyword] = $term;
            }
            $result = $client->search($params);
            if ($result['hits']['total'] > 0) {
                foreach ($result['hits']['hits'] as $hit) {
                    $plank = $hit['_source'];
                    $plank['id'] = $hit['_id'];
                    $planks[] = $plank;
                }
            }
        } else {
            // if search query is empty return all planks
            /** @var Plank $plank */
            $planks = $this->getDoctrine()
                ->getRepository('AppBundle:Plank')
                ->findAll();
        }

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

        $plank_id = $plank->getId();

        $em->remove($plank);
        $em->flush();

        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'plank',
            'type' => 'plank',
            'id' => $plank_id,
        ];

        $client->delete($params);

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

        if (!empty($plank_fields['id'])) {
            unset($plank_fields['id']);
        }

        $em = $this->getDoctrine()->getManager();
        $plank_obj = $em->getRepository('AppBundle:Plank')->preparePlankObject($plank_fields);

        $em->persist($plank_obj);
        $em->flush();
        $plank_id = $plank_obj->getId();

        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'plank',
            'type' => 'plank',
            'id' => $plank_id,
            'body' => $plank_fields
        ];

        $client->index($params);

        return $this->view(['new_element' => '/api/planks/' . $plank_id], Codes::HTTP_CREATED);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \FOS\RestBundle\View\View
     */
    public function putPlanksAction(Request $request)
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
        $plank_id = $plank_obj->getId();

        $client = ClientBuilder::create()->build();

        $params = [
            'index' => 'plank',
            'type' => 'plank',
            'id' => $plank_id,
        ];

        $result = $client->get($params);

        $plank_from_index = $result['_source'];

        unset($plank_fields['id']);

        $params = [
            'index' => 'plank',
            'type' => 'plank',
            'id' => $plank_id,
            'body' => array_merge($plank_from_index, $plank_fields)
        ];

        $client->index($params);

        return $this->view([], Codes::HTTP_NO_CONTENT);
    }
}
