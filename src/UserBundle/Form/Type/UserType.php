<?php

namespace UserBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\Group;
use UserBundle\Entity\User;

/**
 * Class UserType
 * @package UserBundle\Form\Type
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, [
            'label' => 'Username',
        ]);

        $builder->add('email', EmailType::class, [
            'label' => 'Email',
        ]);

        $builder->add('groups', EntityType::class, [
            'label' => 'Groups',
            'class' => Group::class,
            'multiple' => true,
            'expanded' => true,
            'choice_label' => 'name',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'constraints' => [
                new UniqueEntity([
                    'fields' => ['username'],
                ]),
                new UniqueEntity([
                    'fields' => ['email'],
                ])
            ],
        ]);
    }


}