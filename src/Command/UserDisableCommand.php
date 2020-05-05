<?php

namespace Jacquesndl\EasyAdminPlusBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;
use Jacquesndl\EasyAdminPlusBundle\Entity\User;
use Jacquesndl\EasyAdminPlusBundle\Event\EasyAdminPlusEvents;

/**
 * @author Jacques de Lamballerie <jndl@protonmail.com>
 */
class UserDisableCommand extends Command
{
    protected static $defaultName = 'jacquesndl:easy-admin-plus:user:disable';

    private $em;

    private $dispatcher;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->dispatcher = $dispatcher;
    }

    protected function configure()
    {
        $this
            ->setDescription('Disable an admin')
            ->setDefinition(
                [
                    new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                ]
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');

        /** @var User $user */
        if (null === ($user = $this->em->getRepository(User::class)->findOneByUsername($username))) {
            $io->error(sprintf('User %s was not found', $username));

            return 1;
        }

        $this->dispatcher->dispatch(new GenericEvent($user), EasyAdminPlusEvents::USER_PRE_DISABLE);

        $user->setEnabled(false);
        $this->em->flush();

        $this->dispatcher->dispatch(new GenericEvent($user), EasyAdminPlusEvents::USER_POST_DISABLE);

        $io->success(sprintf('User "%s" disabled', $username));

        return 0;
    }
}
