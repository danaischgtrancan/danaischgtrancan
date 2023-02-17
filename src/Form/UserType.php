<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            // ->add('roles')
            ->add('password', RepeatedType::class,[
                'type'=> PasswordType::class,
                'first_options'=> ['label'=>'Password'],
                'second_options'=> ['label'=> 'Confirm Password']])
            ->add('dayOfBirth',DateType::class)
            ->add('phoneNumber', NumberType::class)
            ->add('gender', ChoiceType::class, array(
                    'choices' => array(
                    // So nut radio button
                    'Male' => 0,
                    'Female' => 1
                ),
                'multiple' => false,
                'expanded' => true
            ))
            ->add('address', TextType::class)
            ->add('FullName', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
