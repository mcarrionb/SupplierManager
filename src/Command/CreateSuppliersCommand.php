<?php

namespace App\Command;

use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSuppliersCommand extends Command
{
    protected static $defaultName = 'app:create-suppliers';

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates sample suppliers in the database.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->em->getRepository(Supplier::class)->count([]) > 0) {
            $output->writeln('Suppliers already exist. Skipping sample data.');
            return 0;
        }

        $suppliersData = [
            ['Hotel Barcelona', 'hotel@barcelona.com', '933123456', 'hotel', true],
            ['Pista Andorra', 'pista@andorra.com', '812345678', 'pista', true],
            ['Complemento 1', 'complemento@example.com', '600112233', 'complemento', false],
            ['Hotel Cambrils', 'hotel@cambrils.com', '954987654', 'hotel', true],
        ];

        foreach ($suppliersData as [$name, $email, $phone, $type, $active]) {
            $supplier = new Supplier();
            $supplier->setName($name);
            $supplier->setEmail($email);
            $supplier->setPhone($phone);
            $supplier->setType($type);
            $supplier->setActive($active);

            $this->em->persist($supplier);
        }

        $this->em->flush();

        $output->writeln('Suppliers created successfully.');

        return 0;
    }
}