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
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Jacquesndl\EasyAdminPlusBundle\Entity\User;
use Jacquesndl\EasyAdminPlusBundle\Event\EasyAdminPlusEvents;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @author Jacques de Lamballerie <jndl@protonmail.com>
 */
class UserCreateCommand extends Command
{
    protected static $defaultName = 'jacquesndl:easy-admin-plus:user:create';

    private $em;

    private $dispatcher;

    private $validator;

    private $encoder;

    public function __construct(EntityManagerInterface $em, EventDispatcherInterface $dispatcher, ValidatorInterface $validator, UserPasswordEncoderInterface $encoder, string $name = null)
    {
        parent::__construct($name);
        $this->em = $em;
        $this->dispatcher = $dispatcher;
        $this->validator = $validator;
        $this->encoder = $encoder;
    }

    protected function configure()
    {
        $this
            ->setDescription('Create an admin')
            ->setDefinition(
                [
                    new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                    new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                    new InputArgument('roles', InputArgument::IS_ARRAY, 'The roles'),
                ]
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');
        $roles = $input->getArgument('roles');

        $this->dispatcher->dispatch(new GenericEvent(), EasyAdminPlusEvents::USER_PRE_CREATE);

        $user = new User();
        $user->setUsername($username)
            ->setPassword($this->encoder->encodePassword($user, $password));

        foreach ($roles as $role) {
            $user->addRole($role);
        }

        $violations = $this->validator->validate($user);

        if ($violations->count()) {
            foreach ($violations as $violation) {
                /* @var ConstraintViolation $violation */
                $io->error(sprintf('%s: %s', ucfirst($violation->getPropertyPath()), mb_strtolower($violation->getMessage())));
            }

            return 1;
        }

        $this->em->persist($user);
        $this->em->flush();

        $this->dispatcher->dispatch(new GenericEvent($user), EasyAdminPlusEvents::USER_POST_CREATE);

        $io->success(sprintf('User "%s" created with role(s) "%s"', $username, implode('", "', $user->getRoles())));

        return 0;
    }
}
