<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
                        // So nut radio button
                        'On Sale' => '0',
                        'Sold Out' => '1'
                    ),

                    // Cho chon nhieu hay khong
                    'multiple' => false,
                    'expanded' => true  
                )
            )
            ->add('descriptions', TextType::class)
            ->add('price', TextType::class)
            ->add(
                'for_gender',
                ChoiceType::class,
                array(
                    'choices' => array(
                        // So nut radio button
                        ' Mens Clothing' => '0',
                        'Womens Clothing' => '1'
                    ),

                    // Cho chon nhieu hay khong
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