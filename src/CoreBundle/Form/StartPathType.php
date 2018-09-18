<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;

class StartPathType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      $builder->add('token', HiddenType::class, array(
        'data' => $options["index"],
        )
      )
      ->add('Suivre', SubmitType::class, array(
    'attr' => array('class' => 'follow'),
        )
      );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        //Add a choices index to $option
        $resolver->setDefaults(array(
            'index'=>null
        ));
    }

}
