<?php

namespace App\Form;

use App\Entity\Figurine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FigurineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $imageConstraints = [
            new Image(
                maxSize: '5M',
                maxSizeMessage: "L'image est trop lourde (maximum {{ limit }} {{ suffix }}).",
                mimeTypesMessage: 'Veuillez envoyer une image valide (jpg, png, webp, gif).',
            ),
        ];

        // À la création l'image est obligatoire ; à la modification elle est facultative
        if ($options['image_required']) {
            $imageConstraints[] = new NotNull(message: 'Veuillez choisir une image.');
        }

        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['maxlength' => 100],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
                'attr' => ['rows' => 5],
            ])
            ->add('price', MoneyType::class, [
                'label' => 'Prix',
                'currency' => 'EUR',
                'html5' => true,
                'scale' => 2,
                'attr' => ['min' => 0, 'step' => '0.01'],
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => 'Image de la figurine',
                'required' => $options['image_required'],
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'constraints' => $imageConstraints,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figurine::class,
            'image_required' => true,
        ]);
        $resolver->setAllowedTypes('image_required', 'bool');
    }
}
