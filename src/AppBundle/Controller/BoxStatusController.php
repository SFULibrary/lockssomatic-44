<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Box;
use AppBundle\Entity\BoxStatus;
use AppBundle\Entity\Pln;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * BoxStatus controller.
 *
 * @Security("has_role('ROLE_USER')")
 * @Route("/pln/{plnId}/box/{boxId}/status")
 * @ParamConverter("pln", options={"id"="plnId"})
 * @ParamConverter("box", options={"id"="boxId"})
 */
class BoxStatusController extends Controller {

    /**
     * Lists all BoxStatus entities.
     *
     * @Route("/", name="box_status_index")
     * @Method("GET")
     * @Template()
     * @param Request $request
     * @param Pln $pln
     * @param Box $box
     */
    public function indexAction(Request $request, Pln $pln, Box $box) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(BoxStatus::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();
        $paginator = $this->get('knp_paginator');
        $boxStatuses = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return array(
            'boxStatuses' => $boxStatuses,
            'pln' => $pln,
            'box' => $box,
        );
    }

    /**
     * Finds and displays a BoxStatus entity.
     *
     * @Route("/{id}", name="box_status_show")
     * @Method("GET")
     * @Template()
     * @param BoxStatus $boxStatus
     * @param Pln $pln
     * @param Box $box
     */
    public function showAction(BoxStatus $boxStatus, Pln $pln, Box $box) {

        return array(
            'boxStatus' => $boxStatus,
            'pln' => $pln,
            'box' => $box,
        );
    }

}
