<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SortingType extends AbstractType
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      if($options['parentIndication']) {
        foreach ($options['choices'] as $entity) {
          $subChoices = [];
          foreach ($entity->getModules() as $otherEntity) {
            $subChoices[$otherEntity->getTitle()] = $otherEntity;
          }
          $choices[$entity->getTitle()] = $subChoices;
        }
        $builder->add('sort', ChoiceType::class, [
        'choices'  => $choices,
        ]);
      }
      else {
        $builder->add('sort', ChoiceType::class, [
        'choices'  => $options['choices'],
        'choice_label' => function ($value, $key, $index) {
          return $value->getTitle();
        }
        ]);
      }
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        //Add a choices index to $option
        $resolver->setDefaults(array(
            'choices'=>null,
            'parentIndication' => false
        ));
    }

}
