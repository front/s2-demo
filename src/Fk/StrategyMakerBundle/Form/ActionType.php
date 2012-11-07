<?php

namespace Fk\StrategyMakerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('challenge')
            ->add('start_date')
            ->add('goal')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Fk\StrategyMakerBundle\Entity\Action'
        ));
    }

    public function getName()
    {
        return 'fk_strategymakerbundle_actiontype';
    }
}
