<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
->add('Quantity', IntergerType::class, 
['label'=>'Quantity'])
->add('save', SubmitType::class);

}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        // Configure your form options here
    ]);
}

}
