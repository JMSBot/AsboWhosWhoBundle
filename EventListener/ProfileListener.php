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
use Asbo\WhosWhoBundle\Entity\FraManager;

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
    public $securityContext;

    /**
     * @var Asbo\WhosWhoBundle\Entity\FraManager  $fraManager
     */
    public $fraManager;

    /**
     * @var string $route
     */
    public $route;

    /**
     * @var string $newRoute
     */
    public $newRoute;

    public function __construct(Router $router, SecurityContext $securityContext, FraManager $fraManager, $route, $newRoute)
    {
        $this->router          = $router;
        $this->securityContext = $securityContext;
        $this->fraManager      = $fraManager;
        $this->route           = $route;
        $this->newRoute        = $newRoute;
    }

    /**
     * Event called when a user going to his profile and if he is en ROLE_WHOSWHO_USER
     *
     * @param FilterControllerEvent $event
     * @todo  Ne reste plus qu'a rediriger l'utilisateur vers son profil who's who
     */
    public function onCoreController(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST === $event->getRequestType()) {
            $routeName = $event->getRequest()->get('_route');

            if ($routeName === $this->route) {

                $fras = $this->fraManager->findByUserAndOwner($this->securityContext->getToken()->getUser());

                if (count($fras) > 0) {
                    $url = $this->router->generate($this->newRoute);
                    $event->setResponse(new RedirectResponse($url));
                }
            }
        }
    }
}
