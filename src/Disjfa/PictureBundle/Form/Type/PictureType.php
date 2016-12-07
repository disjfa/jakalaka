<?php

declare(strict_types=1);

namespace Disjfa\PictureBundle\Form\Type;

use Disjfa\PictureBundle\Entity\Picture;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

/**
 * Class PictureType.
 */
class PictureType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'constraints' => new NotBlank(),
        ]);
        $builder->add('width', NumberType::class, [
            'constraints' => new Range(['min' => 100, 'max' => 2000]),
        ]);
        $builder->add('height', NumberType::class, [
            'constraints' => new Range(['min' => 100, 'max' => 2000]),
        ]);

        $builder->add('elements', CollectionType::class, [
            'entry_type' => ElementType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
            'csrf_protection' => false,
        ]);
    }
}
