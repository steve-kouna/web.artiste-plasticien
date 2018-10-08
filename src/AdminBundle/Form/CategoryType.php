<?php

namespace AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;
use EWZ\Bundle\RecaptchaBundle\Validator\Constraints\IsTrue as RecaptchaTrue;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Description of TransportType
 *
 * @author Steve-KOUNA
 */
class CategoryType extends AbstractType {
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, [
                    'mapped' => false,
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('min' => 2)),
                    ]
                ])
                ->add('file', FileType::class, [
                    'mapped' => false,
                ])
                ->add('recaptcha', EWZRecaptchaType::class, [
                    'mapped'      => false,
                    'constraints' => [
                        new RecaptchaTrue()
                    ]
        ])
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
        return 'admin_category';
    }
}
