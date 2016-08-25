<?php

namespace GlyynnAdminBundle\Dashboard;

class DashboardExample
{
    /**
     * @param ConfigureDashboardEvent $event
     * @return string
     */
    public function get($event)
    {
        $event->getItems()->add($event->getTwig()->render('GlyynnAdminBundle:Dashboard:example.html.twig'));
    }
}