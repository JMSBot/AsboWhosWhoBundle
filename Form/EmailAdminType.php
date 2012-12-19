<?php

namespace Asbo\WhosWhoBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;

class EmailAdminType extends EmailType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('fra', 'sonata_type_model_list');
    }

}
