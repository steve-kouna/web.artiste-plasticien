<?php

namespace AccountBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\NotBlank;
use \Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Description of LoginType
 *
 * @author Steve-KOUNA
 */
class LoginType extends AbstractType {
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', TextType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('min' => 2)),
                    ]
                ])
                ->add('password', PasswordType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('min' => 3)),
                    ]
                ])
                ->add('connexion', SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
                'data_class' => null,
            ]
         );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'accountbundle_login';
    }
}
