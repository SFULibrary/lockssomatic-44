<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Tests\Controller;

use AppBundle\DataFixtures\ORM\LoadAuStatus;
use Nines\UserBundle\DataFixtures\ORM\LoadUser;
use Nines\UtilBundle\Tests\Util\BaseTestCase;

class AuStatusControllerTest extends BaseTestCase {
    protected function getFixtures() {
        return [
            LoadUser::class,
            LoadAuStatus::class,
        ];
    }

    public function testAnonIndex() : void {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/pln/1/au/1/status/');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testUserIndex() : void {
        $client = $this->makeClient(LoadUser::USER);
        $crawler = $client->request('GET', '/pln/1/au/1/status/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminIndex() : void {
        $client = $this->makeClient(LoadUser::ADMIN);
        $crawler = $client->request('GET', '/pln/1/au/1/status/');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAnonShow() : void {
        $client = $this->makeClient();
        $crawler = $client->request('GET', '/pln/1/au/1/status/1');
        $this->assertSame(302, $client->getResponse()->getStatusCode());
    }

    public function testUserShow() : void {
        $client = $this->makeClient(LoadUser::USER);
        $crawler = $client->request('GET', '/pln/1/au/1/status/1');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAdminShow() : void {
        $client = $this->makeClient(LoadUser::ADMIN);
        $crawler = $client->request('GET', '/pln/1/au/1/status/1');
        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }
}
