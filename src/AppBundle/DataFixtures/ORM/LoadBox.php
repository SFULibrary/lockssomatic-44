<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Box;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Description of LoadBox
 *
 * @author Michael Joyce <ubermichael@gmail.com>
 */
class LoadBox extends Fixture implements DependentFixtureInterface {
    
    public function load(ObjectManager $em) {
        $box1 = new Box();
        $box1->setHostname('localhost');
        $box1->setProtocol('TCP');
        $box1->setPort('1234');
        $box1->setWebServicePort('11234');
        $box1->setSendNotifications(false);
        $box1->setActive(false);
        $box1->setPln($this->getReference('pln.1'));
        $em->persist($box1);        
        $this->setReference('box.1', $box1);
        
        $box2 = new Box();
        $box2->setHostname('localhost');
        $box2->setProtocol('TCP');
        $box2->setPort('2234');
        $box2->setWebServicePort('22234');
        $box2->setSendNotifications(false);
        $box2->setActive(false);
        $box2->setPln($this->getReference('pln.2'));
        $em->persist($box2);        
        $this->setReference('box.2', $box2);
        $em->flush();
    }

    public function getDependencies() {
        return [
            LoadPln::class,
        ];
    }

}