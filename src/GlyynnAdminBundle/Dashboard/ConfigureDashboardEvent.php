<?php

namespace GlyynnAdminBundle\Dashboard;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\EventDispatcher\Event;
use Twig_Environment;

/**
 * @property ArrayCollection items
 */
class ConfigureDashboardEvent extends Event
{
    const NAME = 'glynn_admin.dashboard_items';
    /**
     * @var Twig_Environment
     */
    private $twig;
    /**
     * @var ArrayCollection
     */
    private $items;

    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
        $this->items = new ArrayCollection();
    }

    /**
     * @return Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    public function getItems()
    {
        return $this->items;
    }
}