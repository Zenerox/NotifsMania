<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = $options['typeCompte'];

        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'label' => 'Mot de passe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de saisir un mot de passe valide',
                    ]),
                    new Length([
                        'min' => 7,
                        'minMessage' => 'Votre mot de passe doit comporter au minimum 
                        {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                        'maxMessage' => 'Votre mot de passe doit comporter au maximum 
                        {{ limit }} caractères',
                    ]),
                ],
            ])
            ->add('type', HiddenType::class, [
                'empty_data' => $type
            ]);
            if ($type == "1") {
                $builder->add('nom', TextType::class, [
                    'constraints' => [
                        new Length([
                            // max length allowed by Symfony for security reasons
                            'max' => 50,
                            'maxMessage' => 'Votre nom ne peut pas comporter plus de  
                        {{ limit }} caractères',
                        ]),
                    ],
                ])
                ->add('prenom', TextType::class, [
                    'constraints' => [
                        new Length([
                            // max length allowed by Symfony for security reasons
                            'max' => 20,
                            'maxMessage' => 'Votre prénom ne peut pas comporter plus de  
                    {{ limit }} caractères',
                        ]),
                    ],
                ]);
            }
            if ($type == "2") {
                $builder->add('siren', TextType::class, [
                    'constraints' => [
                        new Length([
                            // max length allowed by Symfony for security reasons
                            'min' => 6,
                            'max' => 6,
                            'exactMessage' => 'Votre siren doit comporter {{ limit }} chiffres',
                        ]),
                    ],
                ])
                ->add('raisonSociale', TextType::class, [
                    'disabled' => true,
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de saisir un siren valide pour que la raison sociale soit récupérée',
                        ]),
                    ]
                ])
                ->add('activite', ChoiceType::class, [
                    'label' => "Secteur d'activité",
                    'choices' => [
                        "Boulangerie" => "Boulangerie",
                        "Chaussures" => "Chaussures",
                        "Epicerie" => "Epicerie"
                    ],
                    'placeholder' => "Je choisis mon activité dans la liste",
                    'constraints' => [
                        new NotBlank([
                            'message' => "Merci de sélectionner un secteur d'activité"
                        ])
                    ],
                    'help' => "Votre secteur d'activité n'est pas présent? Contactez moi via le formulaire de contact pour le proposer",
                    'help_attr' => [
                        'class' => 'text-muted font-italic font-weight-light'
                    ]
                ])
                ->add('adresse', TextType::class, [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de saisir votre adresse',
                        ]),
                    ]
                ])
                ->add('adresseComplement', TextType::class);
            }
        $builder
            ->add('codePostal', TextType::class, [
                'constraints' => [
                    new Length([
                        'min' => 6,
                        'max' => 6,
                        'exactMessage' => 'Votre code postal doit comporter 6 chiffres'
                    ])
                ]
            ])
            ->add('ville', TextType::class)
            ->add('Submit',SubmitType::class, [
                'attr' => [
                    'class' => 'btn-primary btn btn-block'
                ],
                'label' => "Créer mon compte"
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'typeCompte' => null
        ]);
    }
}
