<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends Abstracttype
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {

    $builder
    ->add('Name', TextType::class, ['label'=> 'Name Custommer'])

    ->add('Phone Number', IntergerType::class,
     [
        'label'=>'Phone Number',
      'attr'=>
      [
       'min'=>10,
       'max'=>10
      ]
      ])

      ->add('save', SubmitType::class)
      ;
}
     
        public function configureOptions(OptionsResolver $resolver): void
      {
          $resolver->setDefaults([
              // Configure your form options here
          ]);
      }
   
   }
