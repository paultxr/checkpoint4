<?php

namespace App\Form;

use App\Entity\Job;
use App\Entity\Techno;
use App\Data\SearchData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SearchForm extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver ) 
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefixe() 
    {
       return '';
    }

    public function buildForm(FormBuilderInterface $builder, array $options) 
    {
        $builder
            ->add('q', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'rechercher'
                ]
            ])
            ->add('job', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Job::class,
                'expanded' => true,
                'multiple' => true,
            ])
        ;
    }
}