<?php

namespace App\Form;;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

/**
 * Class InscriptionType.
 */
class InscriptionType extends AbstractType
{

    /*private $class;

    public function __construct($class)
    {
        $this->class = $class;
    }*/
  
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'personType',
                ChoiceType::class,
                array(
                    'label' => 'form.person_type',
                    'choices' => array_flip(User::$personTypeValues),
                    'expanded' => true,
                    'empty_data' => User::PERSON_TYPE_NATURAL,
                    'required' => true,
                    //'choices_as_values' => true
                )
            )
            ->add(
                'companyName',
                TextType::class,
                array(
                    'label' => 'form.company_name',
                    'required' => false,
                )
            )
            ->add(
                'lastName',
                TextType::class,
                array(
                    'label' => 'form.last_name',
                )
            )
            ->add(
                'firstName',
                TextType::class,
                array(
                    'label' => 'form.first_name',
                )
            )
            ->add(
                'phonePrefix',
                HiddenType::class,
                array(
                    'label' => 'form.user.phone_prefix',
                    'required' => false,
                    'empty_data' => '+33',
                )
            )
            ->add(
                'phone',
                TextType::class,
                array(
                    'label' => 'form.user.phone',
                    'required' => true,
                )
            )
            ->add(
                'email',
                TextType::class,
                array('label' => 'form.email')
            )
            ->add(
                'plainPassword',
                RepeatedType::class,
                array(
                    'type' => PasswordType::class,
                    'options' => array('translation_domain' => 'cocorico_user'),
                    'first_options' => array(
                        'label' => 'form.password',
                        'required' => true,
                    ),
                    'second_options' => array(
                        'label' => 'form.password_confirmation',
                        'required' => true,
                    ),
                    'invalid_message' => 'fos_user.password.mismatch',
                    'required' => true,
                )
            );
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => User::class,
                'csrf_token_id' => 'user_registration',
                'translation_domain' => 'cocorico_user',
                'validation_groups' => array('CocoricoRegistration'),
            )
        );
    }

    /**
     * BC
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getBlockPrefix();
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'user_registration';
    }
}
