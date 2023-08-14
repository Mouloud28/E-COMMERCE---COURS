<?php

namespace App\Form;

use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', null, [
                'label' => 'Nom de la catégorie*',
                'attr' => [
                    'class' => 'border border-success',
                    'placeholder' => 'Saisir le nom de la catégorie'
                ],
                'label_attr' => [
                    'class' => 'text-info'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le nom de la catégorie'
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
