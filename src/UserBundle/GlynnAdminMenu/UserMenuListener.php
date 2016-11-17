<?php

namespace UserBundle\GlynnAdminMenu;

use Doctrine\ORM\EntityManagerInterface;
use GlyynnAdminBundle\Menu\ConfigureMenuEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\User;

/**
 * Class MediaMenuListener
 * @package UserBundle\GlynnAdminMenu
 */
class UserMenuListener
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
     * MediaMenuListener constructor.
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
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $userMenu = $menu->addChild('Users', [
            'route' => 'disjfa_user_user_index'
        ])->setExtra('icon', 'fa-users');
        $userMenu->addChild('Users', ['route' => 'disjfa_user_user_index'])->setExtra('icon', 'fa-users');
        $userMenu->addChild('Groups', ['route' => 'disjfa_user_group_index'])->setExtra('icon', 'fa-tags');
//        $mediaMenu->addChild('Add new', ['route' => 'disjfa_media_asset_create'])->setExtra('icon', 'fa-plus');

    }
}