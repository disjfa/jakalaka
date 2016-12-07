<?php

declare(strict_types=1);

namespace GlyynnAdminBundle\Menu;

/**
 * Class ConfigureMenuListener.
 */
class ConfigureMenuListener
{
    /**
     * @param ConfigureMenuEvent $event
     */
    public function onMenuConfigure(ConfigureMenuEvent $event)
    {
        $menu = $event->getMenu();
        $submenu = $menu->addChild('Submenu', ['route' => 'glynn-admin-submenu'])->setExtra('icon', 'fa-paper-plane');
        $submenu->addChild('Submenu 1', ['route' => 'glynn-admin-submenu1'])->setExtra('icon', 'fa-paper-plane');
        $submenu->addChild('Submenu 2', ['route' => 'glynn-admin-submenu2'])->setExtra('icon', 'fa-paper-plane');
        $submenu3 = $submenu->addChild('Submenu 3', ['route' => 'glynn-admin-submenu3'])->setExtra('icon', 'fa-paper-plane');
        $submenu3->addChild('Sub-submenu 1', ['route' => 'glynn-admin-subsubmenu1'])->setExtra('icon', 'fa-paper-plane');
    }
}
