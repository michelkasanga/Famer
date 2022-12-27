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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('detail')
            ->add('isPublic', CheckboxType::class)
            ->add('imageFile', VichImageType::class)
        
            ->add('category', EntityType::class, 
            [
                'class'=> Category::class,
                'query_builder'=> function (CategoryRepository $r){
                    return $r->createQueryBuilder('i')
                        ->orderBy('i.name', 'ASC');
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
