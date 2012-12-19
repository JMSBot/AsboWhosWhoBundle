<?php

namespace Asbo\WhosWhoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Asbo\WhosWhoBundle\Entity\Fra;


class FraController extends Controller
{
    /**
     * @Route("/", name="asbo_whoswho_home")
     * @Template()
     */
    public function homeAction()
    {
        return array();
    }

}
