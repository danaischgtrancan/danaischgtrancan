<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\ProSup;
use App\Entity\Size;
use App\Entity\Supplier;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, array(
                'constraints' => new Length(array('min' => 3))
            ))
            ->add('descriptions', TextType::class, array(
                // 'constraints' => new Length(array('min' => 30))
            ))
            ->add(
                'status',
                ChoiceType::class,
                array(
                    'choices' => array(
                        'On Sale' => '0',
                        'Sold Out' => '1'
                    ),
                    'multiple' => false,
                    'expanded' => true,
                    'data' => 0
                )
            )
            ->add('price', NumberType::class)
            ->add(
                'forGender',
                ChoiceType::class,
                array(
                    'choices' => array(
                        ' Mens Clothing' => 0,
                        'Womens Clothing' => 1
                    ),
                    'multiple' => false,
                    'expanded' => true
                )
            )
            ->add('image', FileType::class, array('data_class' => null))
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option'
            ])
            ->add('supplier', EntityType::class, [
                'class' => Supplier::class,
                'choice_label' => 'name',
                'placeholder' => 'Choose an option'
            ])
            ->add('save', SubmitType::class, [
                'label' => "Next"
            ]);
    }
}
