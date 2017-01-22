<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    const NB_PER_PAGE = 10;

    /**
     * @Route("/", name="homepage")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/shows", name="shows")
     * @Template()
     */
    public function showsAction(Request $request)
    {
        $repo = $this->getShowsRepository();

        $query = $repo->findAllAsQuery();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            self::NB_PER_PAGE
        );

        return [
            'shows' => $pagination
        ];
    }

    /**
     * @Route("/show/{id}", name="show")
     * @Template()
     */
    public function showAction($id)
    {
        $repo = $this->getShowsRepository();

        return [
            'show' => $repo->find($id)
        ];
    }

    /**
     * @Route("/calendar", name="calendar")
     * @Template()
     */
    public function calendarAction()
    {
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('AppBundle:Episode');
        return [
            'episodes' => $repo->findNextDiffusions()
        ];
    }

    /**
     * @Route("/login", name="login")
     * @Template()
     */
    public function loginAction()
    {
        return [];
    }


    /**
     * @Route("/search", name="search")
     * @Template()
     * @Method("POST")
     * @param Request $request
     * @return array
     */
    public function searchAction(Request $request)
    {
        $repo = $this->getShowsRepository();


        $terms = $request->get('search');
        return [
            'shows' => $repo->findByTerms($terms)
        ];
    }

    /**
     * @return mixed
     */
    protected function getShowsRepository()
    {
        $em = $this->get('doctrine')->getManager();
        $repo = $em->getRepository('AppBundle:TVShow');
        return $repo;
    }
}
