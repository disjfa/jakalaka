<?php

namespace Disjfa\BuilderBundle\GlynnAdminMenu;

use Disjfa\BuilderBundle\Entity\Builder;
use Disjfa\BuilderBundle\Entity\BuilderQuery;
use Disjfa\BuilderBundle\Entity\BuilderRepository;
use Doctrine\ORM\EntityManagerInterface;
use GlyynnAdminBundle\Menu\ConfigureMenuEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\User;

/**
 * Class BuilderMenuListener
 * @package Disjfa\BuilderBundle\GlynnAdminMenu
 */
class BuilderMenuListener
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var User
     */
    private $user;

    /**
     * BuilderMenuListener constructor.
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface $token
     */
    public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $token)
    {
        $this->entityManager = $entityManager;
        if (null !== $token->getToken() && $token->getToken()->getUser() instanceof User) {
            $this->user = $token->getToken()->getUser();
        }
    }

    /**
     * @return BuilderRepository
     */
    public function getBuilderRepository()
    {
        return $this->entityManager->getRepository(Builder::class);
    }

    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $builderMenu = $menu->addChild('Builder', ['route' => 'disjfa_builder_builder_index'])->setExtra('icon', 'fa-paper-plane');
        $builderMenu->addChild('Builder', ['route' => 'disjfa_builder_builder_index'])->setExtra('icon', 'fa-paper-plane');
        if ($this->user && $this->user->hasRole('ROLE_USER')) {
            $builderQuery = new BuilderQuery($this->user);
            $builders = $this->getBuilderRepository()->findByBuilderQuery($builderQuery);
            foreach ($builders as $builder) {
                $builderMenu->addChild($builder->getName(), [
                    'route' => 'disjfa_builder_builder_show',
                    'routeParameters' => ['builder' => $builder->getId()]
                ])->setExtra('icon', 'fa fa-circle');
            }
        }
        $builderMenu->addChild('Add new', ['route' => 'disjfa_builder_builder_create'])->setExtra('icon', 'fa-plus');

    }
}