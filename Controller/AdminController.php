<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Controller of backend
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class AdminController extends Controller
{
    /**
     * @return string
     */
    public function getBaseTemplate()
    {
        if ($this->getRequest()->isXmlHttpRequest()) {
            return $this->container->get('sonata.admin.pool')->getTemplate('ajax');
        }

        return $this->container->get('sonata.admin.pool')->getTemplate('layout');
    }

    /**
     * @Route("/dashboard", name="asbo_whoswho_admin_dashboard")
     * @return Response
     */
    public function dashboardAction()
    {
        return $this->render(
            'AsboWhosWhoBundle:Admin:dashboard.html.twig',
            array(
                'base_template'   => $this->getBaseTemplate(),
                'admin_pool'      => $this->container->get('sonata.admin.pool'),
                'blocks'          => $this->container->getParameter('sonata.admin.configuration.dashboard_blocks'))
        );
    }
}
