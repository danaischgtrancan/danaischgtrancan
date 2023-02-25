<?php

namespace App\Form;

use App\Entity\Order;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderDetailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('products', EntityType::class,[
                'class' => Product::class,
                'choice_label' => 'name'
            ])
            ->add('quantity', TextType::class)            
        ;
    }
}
