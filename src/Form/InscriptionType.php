<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;



class InscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('confirmation', PasswordType::class,['mapped'=>false])
            ->add('personType',ChoiceType::class,array(
                                                        'choices' => array_flip(User::$personTypeValues),
                                                        'expanded' => true,
                                                        'empty_data' => User::PERSON_TYPE_NATURAL,
                                                        'required' => true
                                                    )
                 )
            ->add('lastname', TextType::class)
            ->add('firstname', TextType::class)
            ->add('birthday', BirthdayType::class,array(
                                                        'years' => range(date('Y') - 18, date('Y') - 100),
                                                        //'required' => true,
            ))
            ->add('nationality', CountryType::class,array(
                                                        'required' => true,
                                                        'preferred_choices' => array('GB', 'FR', 'ES', 'DE', 'IT', 'CH', 'US', 'RU'),
                                                        'data' => 'FR',
                                                        )
                )
            ->add('countryofresidence', CountryType::class,array(
                                                        'required' => true,
                                                        'preferred_choices' => array('GB', 'FR', 'ES', 'DE', 'IT', 'CH', 'US', 'RU'),
                                                        'data' => 'FR',
                                                                )
                )
            ->add('phone', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
