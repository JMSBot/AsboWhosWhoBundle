<?php

namespace Asbo\WhosWhoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
use Asbo\WhosWhoBundle\Entity\Email;

class EmailAdminType extends EmailType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('fra', 'sonata_type_model_list');
    }

}
