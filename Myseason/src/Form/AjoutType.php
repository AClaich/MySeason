<?php

namespace App\Form;

use App\Entity\Food;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, ['label'=>'Nom :'])
            ->add('category', ChoiceType::class, ['label' => 'Type : ', 'choice' => ['Fruit' => 1, 'Légume' => 2, 'Céréale' => 3, 'Féculent' => 4]])
            ->add('picture', FileType::MIB_BYTES, ['label' => 'Pièce jointe (image)'])
            ->add('details', TextType::class, ['label' => 'Détails'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Food::class,
        ]);
    }
}
