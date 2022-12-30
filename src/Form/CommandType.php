<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use  Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class CommandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'attr' =>[
                    'class' => 'form-control',
                    'minlength' => '3',
                    'maxlength' => '60'
                    ,
                    'placeholder' => 'Nom Complet'
                ],
              
            ])
            ->add('email', EmailType::class,  [
                'attr'=>[
                    'class'=> 'form-control',
                    'minlength'=> '2',
                    'maxlength'=> '180',
                    'placeholder' => 'Email'
                ],
                'constraints'=> [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=> 2, 'max'=>180])
                ]
            ])
            
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
