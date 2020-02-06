<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{
private function getConfiguration($label,$placeholder){
return [
    'label'=>$label,
    'attr' =>[
        'placeholder'=>$placeholder
    ]
    ];
}


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,$this->getConfiguration("Titre","Tapez un super titre pour votre annonce"))
            ->add('slug', TextType::class,$this->getConfiguration("Adresse web","Tapez l'adresse web (automatique)"))
            ->add('coverImage', UrlType::class,$this->getConfiguration("URL de l'image principale","Donnez l'adresse d'une image qui donne vraiment envie"))
            ->add('introduction', TextType::class,$this->getConfiguration("Introduction","Donnez une Description globale de l'annonce"))
            ->add('content',TextareaType::class,$this->getConfiguration("Description détaillée","Tapes une description qui donne vraiment envie de venir ches vous !"))
            ->add('rooms', IntegerType::class,$this->getConfiguration("nombre de chambres","Le nombre de chambres disponibles"))
            ->add('price',MoneyType::class,$this->getConfiguration("Prix par nuit","Indiquez le prix que vous voulez pour une nuit"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
