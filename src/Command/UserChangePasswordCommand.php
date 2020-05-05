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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @author Jacques de Lamballerie <jndl@protonmail.com>
 */
class UserChangePasswordCommand extends Command
{
    protected static $defaultName = 'jacquesndl:easy-admin-plus:user:change-password';

    private $em;

    private $dispatcher;

    private $encoder;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher, UserPasswordEncoderInterface $encoder, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Change admin password')
            ->setDefinition(
                [
                    new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                    new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                ]
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        /** @var User $user */
        if (null === ($user = $this->em->getRepository(User::class)->findOneByUsername($username))) {
            $io->error(sprintf('User %s was not found', $username));

            return 1;
        }

        $this->dispatcher->dispatch(new GenericEvent($user), EasyAdminPlusEvents::USER_PRE_CHANGE_PASSWORD);

        $user->setPassword($this->encoder->encodePassword($user, $password));
        $this->em->flush();

        $this->dispatcher->dispatch(new GenericEvent($user), EasyAdminPlusEvents::USER_POST_CHANGE_PASSWORD);

        $io->success(sprintf('Password of the user "%s" has been changed to "%s"', $username, $password));

        return 0;
    }
}
