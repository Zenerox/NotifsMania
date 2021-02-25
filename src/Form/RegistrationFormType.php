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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Mot de passe obligatoire',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit comporter {{ limit }} caractères minimum',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmation mot de passe',
                ],
                'invalid_message' => 'Les 2 champs doivent correspondre',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
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
                ])
                ->add('adresse', TextType::class, [
                    'required' => false,
                    'attr' => [
                        'class' => 'adresse'
                    ],
                    'help' => "Remplir votre adresse permettra de calculer la distance entre vous et votre abonnement mais 
                    ceci n'est pas obligatoire",
                    'help_attr' => [
                        'class' => 'text-muted form-help font-weight-light'
                    ]
                ]);
            }
            if ($type == "2") {
                $builder->add('siren', TextType::class, [
                    'help' => "Saisissez votre siren/siret puis sélectionnez le champ 'Raison sociale' pour que cette dernière soit 
                    récupérée automatiquement",
                    'help_attr' => [
                        'class' => 'text-muted form-help font-weight-light'
                    ]
                ])
                ->add('raisonSociale', TextType::class, [
                    'attr' => [
                        'readonly' => true,
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Merci de saisir un siren valide pour que la raison sociale soit récupérée',

                        ]),
                    ]
                ])
                ->add('activite', TextType::class, [
                    'attr' => [
                        'readonly' => true,
                    ],
                    'label' => "Activité",
                    'help' => "Votre intitulé d'activité sera récupéré automatiquement avec votre siren/siret",
                    'help_attr' => [
                        'class' => 'text-muted form-help font-weight-light'
                    ]
                ])
                ->add('internet', CheckboxType::class, [
                    'mapped' => false,
                    'required' => false,
                    'label' => 'Activité exclusivement sur internet ?'
                ])
                ->add('siteInternet', TextType::class, [
                    'required' => false
                ])
                ->add('adresse', TextType::class, [
                    'required' => false,
                    'attr' => [
                        'class' => 'adresse'
                    ],
                ]);
            }
        $builder
            ->add('adresseComplement', TextType::class, [
                'required' => false,
            ])
            ->add('codePostal', TextType::class, [
                'required' => false,
                'constraints' => [
                    new Length([
                        'min' => 5,
                        'max' => 5,
                        'exactMessage' => 'Votre code postal doit comporter 6 chiffres'
                    ])
                ]
            ])
            ->add('ville', TextType::class, [
                'required' => false
            ])
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
