<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormBuilderInterface;


class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
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
            ->add('quantity', NumberType::class)

            // ->add('quantity', NumberType::class, [
            //     'scale'    => 2,
            //     'attr'     => array(
            //         'min'  => 0,
            //         'max'  => 9999.99,
            //         'step' => 0.01,
            //     ),
            // ])
            ->add('image', FileType::class)
            ->add('size', ChoiceType::class,
            array(
                'choices' => array(
                    // So nut radio button
                    'S' => 's',
                    'M' => 'm',
                    'L' => 'l'
                ),

                // Cho chon nhieu hay khong
                'multiple' => false
            ))
            ->add('save', SubmitType::class, [
                'label' => "Add"
            ]);
    }
}
