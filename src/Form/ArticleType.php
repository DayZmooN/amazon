<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\category;
use App\Entity\Merchant;
use App\Entity\order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('price')
            ->add('stock')
            ->add('imgUrl')
            ->add('createdAt', null, [
                'widget' => 'single_text',
            ])
            ->add('description')
            ->add('order_article', EntityType::class, [
                'class' => Order::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('merchant', EntityType::class, [
                'class' => Merchant::class,
                'choice_label' => 'name',
            ])
            ->add('category_article', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
