<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Au;
use AppBundle\Entity\AuStatus;
use AppBundle\Entity\Pln;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * AuStatus controller.
 *
 * @Security("has_role('ROLE_USER')")
 * @Route("/pln/{plnId}/au/{auId}/status")
 * @ParamConverter("pln", options={"id"="plnId"})
 * @ParamConverter("au", options={"id"="auId"})
 */
class AuStatusController extends Controller {
    /**
     * Lists all AuStatus entities.
     *
     * @return array
     *
     * @Route("/", name="au_status_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction(Request $request, Pln $pln, Au $au) {
        if ($au->getPln() !== $pln) {
            throw new NotFoundHttpException('Unknown AU Status.');
        }
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('e')->from(AuStatus::class, 'e')->orderBy('e.id', 'ASC');
        $query = $qb->getQuery();
        $paginator = $this->get('knp_paginator');
        $auStatuses = $paginator->paginate($query, $request->query->getint('page', 1), 25);

        return [
            'auStatuses' => $auStatuses,
            'pln' => $pln,
            'au' => $au,
        ];
    }

    /**
     * Finds and displays a AuStatus entity.
     *
     * @return array
     *
     * @Route("/{id}", name="au_status_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(AuStatus $auStatus, Pln $pln, Au $au) {
        if ($au->getPln() !== $pln) {
            throw new NotFoundHttpException('Unknown AU Status.');
        }
        if ($auStatus->getAu() !== $au) {
            throw new NotFoundHttpException('Unknown AU Status.');
        }

        return [
            'auStatus' => $auStatus,
            'pln' => $pln,
            'au' => $au,
        ];
    }
}
