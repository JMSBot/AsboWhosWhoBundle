<?php

/*
 * This file is part of the ASBO package.
 *
 * (c) De Ron Malian <deronmalian@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Asbo\WhosWhoBundle\EventListener;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;

/**
 * Profile event listener
 *
 * @author De Ron Malian <deronmalian@gmail.com>
 */
class ProfileListener
{
    /**
     * @var Symfony\Component\Routing\Router $router
     */
    public $router;

    /**
     * @var Symfony\Component\Security\Core\SecurityContext $securityContext
     */

    /**
     * @var string $route
     */
    public $route;

    /**
     * @var string $newRoute
     */
    public $newRoute;

    public function __construct(Router $router, SecurityContext $securityContext, $route, $newRoute)
    {
        $this->router          = $router;
        $this->securityContext = $securityContext;
        $this->route           = $route;
        $this->newRoute        = $newRoute;
    }

    /**
     * Event called when a user going to his profile and if he is en ROLE_WHOSWHO_USER
     *
     * @param FilterControllerEvent $event
     */
    public function onCoreController(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $routeName = $event->getRequest()->get('_route');

            if ($routeName === $this->route && $this->securityContext->isGranted('ROLE_WHOSWHO_USER')) {
                $url = $this->router->generate($this->newRoute);
                $event->setResponse(new RedirectResponse($url));
            }
        }
    }
}
