<?php
namespace Asbo\WhosWhoBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Route\RouteCollection;

class WhosWhoAdmin extends Admin
{

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection->add('test');
    }

    public function unpublishAction(Request $request)
    {
    }

}
