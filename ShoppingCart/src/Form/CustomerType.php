<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\Extension\Core\Type\IntegerType;




class CustomerType extends Abstracttype
{
  public function buildForm(FormBuilderInterface $builder, array $options): void
  {
    // add email into the User class
    $builder


    ->add('email', EntityType::class,
    [
      'label'=>'Email',

      'class'=>User::class,



    ])

      ->add(
      'phoneNumber', TextType::class ,
    [
      'label' => 'Phone Number',
      'constraints' => [
        new Length([
          'max' => 10
        ])
      ],

    ]
    )

      ->add('save', SubmitType::class);
  }

  public function configureOptions(OptionsResolver $resolver): void
  {
    $resolver->setDefaults([
      // Configure your form options here
    ]);
  }
}
