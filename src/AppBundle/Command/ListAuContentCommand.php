<?php

namespace AppBundle\Command;

use AppBundle\Entity\Au;
use AppBundle\Services\AuManager;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * LomValidateAuCommand command.
 */
class ListAuContentCommand extends ContainerAwareCommand {

    /**
     * AU Manager.
     *
     * @var AuManager
     */
    private $manager;

    /**
     * Doctrine instance.
     *
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Construct the command.
     *
     * @param EntityManagerInterface $em
     *   Dependency-injected doctrine instance.
     * @param AuManager $manager
     *   Dependency-injected au manager service.
     */
    public function __construct(EntityManagerInterface $em, AuManager $manager) {
        parent::__construct(null);
        $this->manager = $manager;
        $this->em = $em;
    }

    /**
     * Configure the command.
     */
    protected function configure() {
        $this->setName('lom:list:au');
        $this->setDescription('List the content in an AU.');
        $this->addArgument('ids', InputArgument::IS_ARRAY, "List of AU database ids to check");
    }

    /**
     * Fetch a list of AUs to query from the database.
     *
     * @param array $ids
     *   List of AU database IDs to check.
     *
     * @return Au[]|Collection
     *   List of AUs to query.
     */
    protected function getAus(array $ids) {
        if (count($ids) === 0) {
            return $this->em->getRepository(Au::class)->findAll();
        }
        return $this->em->getRepository(Au::class)->findBy(array(
            'id' => $ids,
        ));
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     *   Command input, as defined in the configure() method.
     * @param OutputInterface $output
     *   Output destination.
     */
    protected function execute(InputInterface $input, OutputInterface $output) {
        foreach ($this->getAus($input->getArgument('ids')) as $au) {
            $iterator = $this->em->getRepository(Au::class)->iterateDeposits($au);
            while(($deposit = $iterator->current())) {
                $output->writeln($deposit->getUrl());
                $iterator->next();
            }
        }
    }

}