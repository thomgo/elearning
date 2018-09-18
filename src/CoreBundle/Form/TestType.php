<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class TestType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title')
        ->add('article',  EntityType::class, [
          'class'=> 'CoreBundle:Article',
          'choice_label'=> 'title',
          "expanded" => false,
        ])
        ->add('testBlocs', CollectionType::class, array(
        'entry_type'   => TestBlocType::class,
        'allow_add'    => true,
        'allow_delete' => true,
        'by_reference' => false
        ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Test'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_test';
    }


}
