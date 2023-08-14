<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\Matiere;
use App\Entity\Produit;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Count;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', null, [
                // key => value
                // key : nom de l'option
                'label' => 'Titre du produit',
                'attr' => [
                    'class' => 'border border-success',
                    'placeholder' => 'Saisir le titre du produit'
                ],
                'label_attr' => [
                    'class' => 'text-info'
                ],
                'help' => 'Le titre du produit doit être compris entre 5 et 20 caractères',
                'help_attr' => [
                    'class' => 'text-primary fst-italic'
                ],
                'row_attr' => [
                    'class' => 'border border-dark p-3 rounded col-md-6'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le titre du produit'
                    ]),
                    new Length([
                        'min' => 5,
                        'max' => 20,
                        'minMessage' => 'Veuillez saisir un titre d\'au moins 5 caractères',
                        'maxMessage' => 'Veuillez saisir un titre de moins de 20 caractères'
                    ])
                ]
            ])

            ->add('prix', MoneyType::class, [
                //'currency' => 'USD',
                'label' => 'Prix du produit',
                'required' => false,
                'attr' => [
                    'class' => 'border border-success',
                    'placeholder' => 'Saisir le prix du produit'
                ],
                'label_attr' => [
                    'class' => 'text-info'
                ],
                'help' => 'Le prix du produit doit être un nombre supérieur à 0',
                'help_attr' => [
                    'class' => 'text-primary fst-italic'
                ],
                'row_attr' => [
                    'class' => 'border border-dark p-3 rounded col-md-6'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez saisir le prix du produit'
                    ]),
                    new Positive([
                        'message' => 'Veuillez saisir un montant supérieur à zéro'
                    ])
                ]
            ])
            
            ->add('description', null, [
                // key => value
                // key : nom de l'option
                'label' => 'Description du produit (facultative)',
                'attr' => [
                    'class' => 'border border-success',
                    'placeholder' => 'Saisir la description du produit',
                    'rows' => 6
                ],
                'label_attr' => [
                    'class' => 'text-info'
                ],
                'help' => 'La description du produit doit contenir moins de 200 caractères',
                'help_attr' => [
                    'class' => 'text-primary fst-italic'
                ],
                'row_attr' => [
                    'class' => 'border border-dark p-3 rounded'
                ],
                'constraints' => [
                    new Length([
                        'max' => 200,
                        'maxMessage' => 'Veuillez saisir une description de moins de 200 caractères'
                    ])
                ]
            ])


            ->add('categorie', EntityType::class, [ // Si relation définir EntityType
                'class' => Categorie::class,        // nom de la class(entity = table)
                'choice_label' => 'nom',             // propriété de l'objet à afficher
                //'expanded' => true,                // en fonction de la relation : radio ou checkbox
                // 'multiple' => true, UNIQUEMENT POUR LES RELATIONS ManyToMany
                'placeholder' => 'Sélectionnez une catégorie',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez sélectionner une catégorie'
                    ])
                 ]
            ])


            ->add('matieres', EntityType::class, [ // Si relation définir EntityType
                'class' => Matiere::class,        // nom de la class(entity = table)
                'choice_label' => 'nom',             // propriété de l'objet à afficher
                'expanded' => true,                // en fonction de la relation : radio ou checkbox
                'multiple' => true, //UNIQUEMENT POUR LES RELATIONS ManyToMany
                //'placeholder' => 'Sélectionnez une matière',
                'required' => false,
                'constraints' => [
                    new Count([
                        'min' => 1,
                        'minMessage' => 'Veuillez sélectionner au moins une matière'
                    ])
                 ]
            ])

            // ->add('ajouter', SubmitType::class)
        ;

        /*
            Rappel composition à l'intérieur dans une balise <form></form>
            input type="text number checkbox radio file date color password email submit hidden ...."
            textarea
            select

            méthode add()
            1e argument obligatoire (str)
            Si la class est reliée à une entity, la string est le nom d'une propriété

            2e argument (class)  ou null
            Class qui définit le "type" de la balise (Textarea et Select aussi)
            s'il n'y a pas de class, il se basera sur le type de la propriété dans l'entity

            3e argument (array)
            tableau des options

            2 "types" d'options :
                - inherited (commun à toutes les class)
                - options propres à la class
            

        */

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
