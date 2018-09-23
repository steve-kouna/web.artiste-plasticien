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

/**
 * Description of TransportType
 *
 * @author Steve-KOUNA
 */
class TransportType extends AbstractType {
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name', TextType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('min' => 2)),
                    ]
                ])
                ->add('detail', TextareaType::class, [
                    'mapped' => false,
                    'constraints' => [
                        new NotBlank(),
                        new Length(array('min' => 3)),
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
        return 'adminbundle_Transport';
    }
}
