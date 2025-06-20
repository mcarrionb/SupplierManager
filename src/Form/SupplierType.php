<?php

namespace App\Form;

use App\Entity\Supplier;
use App\Enum\SupplierCategoryEnum;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SupplierType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nombre',
            ])
            ->add('email', null, [
                'label' => 'Email',
            ])
            ->add('phone', null, [
                'label' => 'Teléfono',
            ])
            ->add('type', ChoiceType::class, [
                'choices' => SupplierCategoryEnum::getChoices(),
                'placeholder' => 'Selecciona un tipo',
                'label' => 'Tipo',
                'attr' => ['class' => 'form-select'],
            ])
            ->add('active', null, [
                'label' => 'Activo',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Supplier::class,
        ]);
    }
}
