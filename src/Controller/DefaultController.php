<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace App\Controller;

use Nines\UtilBundle\Controller\PaginatorTrait;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Knp\Bundle\PaginatorBundle\Definition\PaginatorAwareInterface;

/**
 * Default controller for LOCKSSOMatic. Totally open to the public.
 */
class DefaultController extends AbstractController implements PaginatorAwareInterface {
    use PaginatorTrait;
    /**
     * LOCKSSOMatic home page.
     *
     * @return Response
     *
     * @Route("/", name="homepage")
     */
    public function indexAction() {
        $user = $this->getUser();

        if ( ! $user || ! $user->hasRole('ROLE_USER')) {
            return $this->render('default/index_anon.html.twig');
        }

        return $this->render('default/index_user.html.twig');
    }
}