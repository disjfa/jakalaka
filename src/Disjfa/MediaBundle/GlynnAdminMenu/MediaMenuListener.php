<?php

namespace Disjfa\MediaBundle\GlynnAdminMenu;

use Doctrine\ORM\EntityManagerInterface;
use GlyynnAdminBundle\Menu\ConfigureMenuEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\User;

/**
 * Class MediaMenuListener
 * @package Disjfa\MediaBundle\GlynnAdminMenu
 */
class MediaMenuListener
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
        $mediaMenu = $menu->addChild('Media', ['route' => 'disjfa_media_asset_index'])->setExtra('icon', 'fa-file-o');
        $mediaMenu->addChild('Assets', ['route' => 'disjfa_media_asset_index'])->setExtra('icon', 'fa-file-o');
        $mediaMenu->addChild('Add new', ['route' => 'disjfa_media_asset_create'])->setExtra('icon', 'fa-plus');

    }
}