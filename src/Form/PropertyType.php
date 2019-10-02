<?php

namespace App\Form;

use App\Entity\Option;
use App\Entity\Property;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description du bien'
            ])
            ->add('surface')
            ->add('rooms', IntegerType::class, [
                'label' => 'Nombre de Pièces'
            ])
            ->add('bedrooms',IntegerType::class, [
                'label' => 'Nombre de chambres'
            ])
            ->add('floor', IntegerType::class, [
                'label' => 'Etage'
            ])
            ->add('price', IntegerType::class, [
                'label' => 'Prix'
            ])
            ->add('heat', ChoiceType::class, [
                'choices' => $this->getChoices(),
                'label' => 'Type de chauffage'
            ])
            ->add('options', EntityType::class, [
                'class' => Option::class,
                'choice_label' => 'name',
                'multiple' => true,
                'required' => false,
            ])
            ->add('imageFile',  FileType::class, [
                'required' => false,
                'label' => 'Fichier image'
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville'
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse'
            ])
            ->add('postal_code', TextType::class, [
                'label' => 'Code postal'
            ])
            ->add('sold',  CheckboxType::class, [
                'label' => 'Vendu',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }

    private function getChoices(): array
    {
        $choices = Property::HEAT;
        $outPut = [];

        foreach ($choices as $k => $v){
            $outPut[$v] = $k;
        }

        return $outPut;
    }
}
