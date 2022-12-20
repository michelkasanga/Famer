<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use  Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           ->add('fullName', TextType::class, [
                'attr'=>[
                    'class'=> 'form-control',
                    'minlength'=> '2',
                    'maxlength'=> '50'
                ],
                'label'=>  'Nom / Prenom *',
                'label_attr'=>[
                    'class'=> 'form-label mt-4'
                ],
                'constraints'=> [
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 3, 'max'=>60])
                ]
            ])
            ->add('username',  TextType::class, [
                'attr'=>[
                    'class'=> 'form-control',
                    'minlength'=> '5',
                    'maxlength'=> '180'
                ],
                'label'=>  'Nom d\'utilisateur *',
                'required' => true,
                'label_attr'=>[
                    'class'=> 'form-label mt-4'
                ],
                'constraints'=> [
                    new Assert\NotBlank(),
                    new Assert\Length(['min'=> 5, 'max'=>180])
                ]
            ])
            ->add('email', EmailType::class,  [
                'attr'=>[
                    'class'=> 'form-control',
                    'minlength'=> '5',
                    'maxlength'=> '180'
                ],
                'label'=>  'Email *',
                'label_attr'=>[
                    'class'=> 'form-label mt-4'
                ],
                'constraints'=> [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Length(['min'=> 5, 'max'=>180])
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
            ->add('plainPassword',  RepeatedType::class, [
                'type'=> PasswordType::class,
                'first_options' => [
                    'attr'=>[
                        'class'=> 'form-control',
                    ],
                    'label'=>  'Mot de passe*',
                    'label_attr'=>[
                        'class'=> 'form-label mt-4'
                    ]
                ], 
                'second_options'=> [
                    'attr'=>[
                        'class'=> 'form-control',
                    ],
                    'label'=>  'Confirmer le mot de passe*',
                    'label_attr'=>[
                        'class'=> 'form-label mt-4'
                    ]
                ],
                'invalid_message' => 'Les mots de passe ne correspondent pas'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
