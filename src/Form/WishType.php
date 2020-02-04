<?php

namespace App\Form;

use App\Entity\Wish;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['label' => 'Заголовок'])
            ->add('description', TextType::class, ['label' => 'Описание'])
            ->add('url', TextType::class, ['label' => 'Ссылка', 'required' => false])
            ->add('image', TextType::class, ['label' => 'Картинка', 'required' => false])
            ->add('status', TextType::class, ['label' => 'Статус'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Wish::class,
        ]);
    }
}
