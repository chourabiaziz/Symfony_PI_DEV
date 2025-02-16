<?php

namespace App\Form;

use App\Entity\Commande;
use App\Entity\LigneCommande;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Commande1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lignes', EntityType::class, [
            'class' => LigneCommande::class,
            'choice_label' => function (LigneCommande $ligneCommande) {
                return 'prix unitére ' . $ligneCommande->getPrixUnitaire() . ' - Quantité: ' . $ligneCommande->getQuantite();
            },
            'multiple' => true, // Permet la sélection multiple
            'expanded' => true, // Affiche sous forme de cases à cocher
            'label' => 'Lignes de Commande',
        ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
