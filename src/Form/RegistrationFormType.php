<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,['required'=>true,'constraints'=>[
                new Length([
                    'min' => 3,
                    'max' => 15,
                    'exactMessage'=>'Nom entre 3 et 15 caractères',
                ]),]])
            ->add('prenom',null,['required'=>true,'constraints'=>[
                new Length([
                    'min' => 3,
                    'max' => 15,
                    'exactMessage'=>'Prénom entre 3 et 15 caractères',
                ]),]])
            ->add('tel',IntegerType::class,['required'=>true,'label'=>'Téléphone : ', 'constraints'=>[
                new Length([
                    'min' => 8,
                    'max' => 8,
                    'exactMessage'=>'Le numéro de téléphone doit contenir exactement {{ limit }}  chiffres',
                ]),]])
            ->add('adresse',null,['required'=>true,'constraints'=>[
                new Length([
                    'min' => 8,
                    'max' => 45,
                    'exactMessage'=>'Adresse très courte',
                ]),]])
            ->add('username',null,['required'=>true,'constraints'=>[
                new Length([
                    'min' => 5,
                    'max' => 15,
                    'exactMessage'=>'Username entre 5 et 15 caractères',
                ]),]])
            ->add('email',EmailType::class,['required'=>true,'label'=>'E-mail : ','constraints'=>[
                new Email(['mode' => 'strict']),
            ]])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les champs de mot de passe doivent correspondre',
                'options' => ['attr' => ['class' => 'password-field','style'=> 'padding :20px']],
                'required' => true,
                'first_options' => ['label' => 'Mot de passe : '],
                'second_options' => ['label' => 'Confirmer mot de passe : '],
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
