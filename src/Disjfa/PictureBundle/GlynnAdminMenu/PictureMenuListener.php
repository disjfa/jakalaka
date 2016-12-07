<?php

declare(strict_types=1);

namespace Disjfa\PictureBundle\GlynnAdminMenu;

use Doctrine\ORM\EntityManagerInterface;
use GlyynnAdminBundle\Menu\ConfigureMenuEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use UserBundle\Entity\User;

class PictureMenuListener
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
     *
     * @param EntityManagerInterface $entityManager
     * @param TokenStorageInterface  $token
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
        $mediaMenu = $menu->addChild('Picture', ['route' => 'disjfa_picture_picture_index'])->setExtra('icon', 'fa-picture-o');
        $mediaMenu->addChild('Picture', ['route' => 'disjfa_picture_picture_index'])->setExtra('icon', 'fa-picture-o');
        $mediaMenu->addChild('Add new', ['route' => 'disjfa_picture_picture_create'])->setExtra('icon', 'fa-plus');
    }
}
