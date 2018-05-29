<?php

/*
 *  This file is licensed under the MIT License version 3 or
 *  later. See the LICENSE file for details.
 *
 *  Copyright 2018 Michael Joyce <ubermichael@gmail.com>.
 */

namespace AppBundle\Command\Lockss;

use AppBundle\Entity\Deposit;
use AppBundle\Services\LockssClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Fetch a file from the LOCKSS network.
 */
class FetchFileCommand extends ContainerAwareCommand {

    /**
     * Doctrine instance.
     *
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * LOCKSS client service.
     *
     * @var LockssClient
     */
    private $client;

    /**
     * Build the command.
     *
     * @param EntityManagerInterface $em
     *   Dependency injected doctrine instance.
     * @param LockssClient $client
     *   Dependency injected LOCKSS client.
     */
    public function __construct(EntityManagerInterface $em, LockssClient $client) {
        parent::__construct();
        $this->client = $client;
        $this->em = $em;
    }

    /**
     * Configure the command.
     */
    protected function configure() {
        $this->setName('lockss:content:fetch');
        $this->setDescription('Report the status of an AU.');
    }

    /**
     * Determine which deposits to fetch.
     *
     * @return Deposit[]|Collection
     *   List of deposits to fetch.
     */
    protected function getDeposits() {
        $contents = $this->em->getRepository(Deposit::class)->findAll();
        return $contents;
    }

    /**
     * @inheritdoc
     */
    public function execute(InputInterface $input, OutputInterface $output) {
        $deposits = $this->getDeposits();
        foreach ($deposits as $deposit) {
            $output->writeln($deposit->getUrl());
            foreach ($deposit->getAu()->getPln()->getBoxes() as $box) {
                $output->writeln($box->getIpAddress());
                $fh = $this->client->fetchFile($box, $deposit);
                $context = hash_init('sha1');
                while (($data = fread($fh, 64 * 1024))) {
                    hash_update($context, $data);
                }
                print hash_final($context) . "\n";
            }
        }
    }

}