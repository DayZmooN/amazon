<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Order;
use App\Entity\user;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Order1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status')
            ->add('totalPrice')
            ->add('date', null, [
                'widget' => 'single_text',
            ])
            ->add('articles', EntityType::class, [
                'class' => Article::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('user_order', EntityType::class, [
                'class' => user::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
