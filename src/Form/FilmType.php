<?php

namespace App\Form;

use DateTime;
use App\Entity\Film;

use App\Entity\Genre;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class FilmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class,[
                'attr' => ['class' => 'form-control']
            ])
            ->add('synopsis', TextareaType::class,[
                'required'   => false,
                'attr' => ['class' => 'form-control']
            ])
            ->add('duree', IntegerType::class, [
                'attr' => ['class' => 'form-control']
            ])
            ->add('dateSortie', DateType::class, [
                'attr' => ['class' => 'js-datepicker'],
                'years' => range(date('Y'),date('Y')-70),
                'format' => 'ddMMyyyy',
            ])
            ->add('genre', EntityType::class, [
                
                'multiple'=> false,
                'expanded'=> true,
                'label'=> 'Genre Cynématografique' ,
                'class' => Genre::class,
                'choice_label'=>'nomGenre'
            ])
            ->add('Enregistrer', SubmitType::class, [
                'attr' => ['class' => 'btn btn-primary uk-margin-top']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Film::class,
        ]);
    }
}
