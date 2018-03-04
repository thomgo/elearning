<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class ArticleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title')
        ->add('content', TextareaType::class, array('attr' => array('class' => 'articleContent')))
        ->add('date')
        //The user is not forced to submit an image therefor this form is not required
        ->add('image', ImageType::class, [
          'required' => false
        ])
        ->add('categories', EntityType::class, [
          'class'=> 'CoreBundle:Category',
          'choice_label'=> 'name',
          'multiple' => true,
          "expanded" => true,
        ])
        ->add('module', EntityType::class, [
          'class'=> 'CoreBundle:Module',
          'choice_label'=> 'title',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Article'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'corebundle_article';
    }


}
