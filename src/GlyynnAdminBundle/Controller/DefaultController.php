<?php

namespace GlyynnAdminBundle\Controller;

use GlyynnAdminBundle\Dashboard\ConfigureDashboardEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="glynn-admin-homepage")
     */
    public function indexAction()
    {
        $dashboardItems = $this->get('event_dispatcher')->dispatch(
            ConfigureDashboardEvent::NAME,
            new ConfigureDashboardEvent($this->get('twig'))
        );

        return $this->render('GlyynnAdminBundle:Default:index.html.twig', [
            'dashboardItems' => $dashboardItems,
        ]);
    }

    /**
     * @Route("/submenu", name="glynn-admin-submenu")
     */
    public function submenuAction()
    {
        return $this->render('GlyynnAdminBundle:Default:submenu.html.twig');
    }

    /**
     * @Route("/submenu1", name="glynn-admin-submenu1")
     */
    public function submenu1Action()
    {
        return $this->render('GlyynnAdminBundle:Default:submenu1.html.twig');
    }

    /**
     * @Route("/submenu2", name="glynn-admin-submenu2")
     */
    public function submenu2Action()
    {
        return $this->render('GlyynnAdminBundle:Default:submenu.html.twig');
    }

    /**
     * @Route("/submenu3", name="glynn-admin-submenu3")
     */
    public function submenu3Action()
    {
        return $this->render('GlyynnAdminBundle:Default:submenu.html.twig');
    }

    /**
     * @Route("/subsubmenu1", name="glynn-admin-subsubmenu1")
     */
    public function subsubmenu1Action()
    {
        return $this->render('GlyynnAdminBundle:Default:submenu.html.twig');
    }

    /**
     * @Route("/subsubsubmenu1", name="glynn-admin-subsubsubmenu1")
     */
    public function subsubsubmenu1Action()
    {
        return $this->render('GlyynnAdminBundle:Default:submenu.html.twig');
    }
}
