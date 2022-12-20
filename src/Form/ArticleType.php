<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use  Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name' ,TextType::class, [
                'attr' => [
                    'class' =>'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'
                ],
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min'=>2, 'max'=>50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('price' , MoneyType::class,  [
                'attr' => [
                    'class' =>'form-control',
                    
                ],
                'label' => 'Prix',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [ 
                    new Assert\Positive(),
                   new Assert\LessThan(1001)
                ]
                  
            ])
            ->add('detail', TextareaType::class, [
                'attr' =>[
                    'class' => 'form-control',
                    'minlength' => '5'
                    // 'maxlength' => '300'
                ],
                'label' => 'Description',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [ 
                    new Assert\NotBlank()
                ] 
            ])
            ->add('isPublic', CheckboxType::class,  [
         
                'required'=>false,
               'label' => 'Favoris  ?',
               
               'label_attr' => [
                   'class' => 'form-check-label'
               ],
               'attr' => [
                   'class' =>'form-check-input',
                   'role' => 'switch',
                   
               ],   
               'constraints' => [ 
                   new Assert\NotNull()
               ]
                 
           ])
            ->add('imageFile' , VichImageType::class, [
                'label' => 'Image de la recette',
                'label_attr'=> [
                    'class' => 'form-label  mt-4'
                ],
                'attr'=> [
                    'class' => 'form-control'
                ]
               ])
            ->add('category', EntityType::class,    [
                'class'=> Category::class,
                'query_builder'=> function (CategoryRepository $r){
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC')
                        ;
                },
                'multiple' => false,
                'expanded' => true,
                'choice_label' => 'name'
            ])
         
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
