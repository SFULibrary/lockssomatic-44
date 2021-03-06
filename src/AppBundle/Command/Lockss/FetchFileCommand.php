<?php

declare(strict_types=1);

/*
 * (c) 2020 Michael Joyce <mjoyce@sfu.ca>
 * This source file is subject to the GPL v2, bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Command\Lockss;

use AppBundle\Entity\Deposit;
use AppBundle\Services\FilePaths;
use AppBundle\Services\LockssClient;
use Doctrine\ORM\EntityManagerInterface;
use Generator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

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
     * File path service.
     *
     * @var FilePaths
     */
    private $filePaths;

    /**
     * File system utility.
     *
     * @var Filesystem
     */
    private $fs;

    /**
     * Build the command.
     */
    public function __construct(EntityManagerInterface $em, LockssClient $client, FilePaths $filePaths) {
        parent::__construct();
        $this->client = $client;
        $this->em = $em;
        $this->filePaths = $filePaths;
        $this->fs = new Filesystem();
    }

    /**
     * Configure the command.
     */
    protected function configure() : void {
        $this->setName('lockss:deposit:fetch');
        $this->addOption('uuid', null, InputOption::VALUE_NONE, 'Arguments are deposit UUIDs.');
        $this->addArgument('id', InputArgument::IS_ARRAY, 'One or more IDs to fetch.');
        $this->setDescription('Fetch one or more deposits from the network.');
    }

    /**
     * Determine which deposits to fetch.
     *
     * At least one of $ids, $uuids must not be empty.
     *
     * @param bool $uuids
     *
     * @return Deposit[]|Generator
     */
    protected function getDeposits(array $ids, $uuids) {
        $repo = $this->em->getRepository(Deposit::class);
        $qb = $repo->createQueryBuilder('d');
        if ($uuids) {
            $qb->where('d.uuid in (:ids)');
        } else {
            $qb->where('d.id in (:ids)');
        }
        $qb->setParameter('ids', $ids);
        $iterator = $qb->getQuery()->iterate();
        foreach ($iterator as $row) {
            yield $row[0];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function execute(InputInterface $input, OutputInterface $output) : void {
        $ids = $input->getArgument('id');
        $uuids = $input->getOption('uuid');
        $deposits = $this->getDeposits($ids, $uuids);
        $path = null;

        foreach ($deposits as $deposit) {
            $pln = $deposit->getContentProvider()->getPln();
            $boxes = $pln->getActiveBoxes(true);
            foreach ($boxes as $box) {
                // debugging crap.
                if (1 !== $box->getId()) {
                    continue;
                }

                echo "fetching from {$box}\n";
                $fh = $this->client->fetchFile($box, $deposit);
                if ( ! $fh) {
                    continue;
                }
                $context = hash_init($deposit->getChecksumType());
                while (($data = fread($fh, 64 * 1024))) {
                    hash_update($context, $data);
                }
                $checksum = strtoupper(hash_final($context));
                if ($checksum !== $deposit->getChecksumValue()) {
                    $output->writeln("Checksum verification failed for {$box->getHostname()}");

                    continue;
                }
                rewind($fh);
                $path = $this->filePaths->getDownloadContentPath($deposit);
                while (($data = fread($fh, 64 * 1024))) {
                    $this->fs->appendToFile($path, $data);
                }
                $output->writeln("Deposit written to {$path}.");

                break;
            }
        }
    }
}
