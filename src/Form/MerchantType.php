<?php

namespace App\Form;

use App\Entity\Merchant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class MerchantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('address')
            ->add('createdAt', DateTimeType::class, [
                'widget' => 'single_text',
                'data' => new \DateTimeImmutable(),
            ]);

        // Nous ne ajoutons plus le champ user_merchant ici
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Merchant::class,
        ]);
    }
}
