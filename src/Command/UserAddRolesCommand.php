<?php

namespace Jacquesndl\EasyAdminPlusBundle\Command;

use Jacquesndl\EasyAdminPlusBundle\Entity\User;
use Jacquesndl\EasyAdminPlusBundle\Event\EasyAdminPlusEvents;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

/**
 * @author Jacques de Lamballerie <jndl@protonmail.com>
 */
class UserAddRolesCommand extends Command
{
    protected static $defaultName = 'jacquesndl:easy-admin-plus:user:add-roles';

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
            ->setDescription('Add roles to an admin')
            ->setDefinition(
                [
                    new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                    new InputArgument('roles', InputArgument::IS_ARRAY, 'The roles'),
                ]
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $roles = $input->getArgument('roles');

        /** @var User $user */
        if (null === ($user = $this->em->getRepository(User::class)->findOneByUsername($username))) {
            $io->error(sprintf('User %s was not found', $username));

            return 1;
        }

        $this->dispatcher->dispatch(new GenericEvent($user), EasyAdminPlusEvents::USER_PRE_UPDATE_ROLES);

        if (empty($roles)) {
            $io->error(sprintf('No role added to the user %s', $username));

            return 1;
        }

        foreach ($roles as $role) {
            $user->addRole($role);
        }

        $this->em->flush();

        $this->dispatcher->dispatch(new GenericEvent($user), EasyAdminPlusEvents::USER_POST_UPDATE_ROLES);

        $io->success(sprintf('Role(s) of the user "%s" is now "%s"', $username, implode('", "', $user->getRoles())));

        return 0;
    }
}
