<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use FOS\UserBundle\Util\LegacyFormHelper;
use Symfony\Component\Validator\Constraints as Assert;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //$builder->add('name');
        $builder->add(
          'email',
          LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\EmailType'),
          array(
            'label' => 'form.email',
            'translation_domain' => 'FOSUserBundle',
            'constraints' => array(
              new Assert\Email(),
            )
          )
        )
         ->add(
          'enabled', null,
          array('label' => 'Habilitado', )
        );

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
            $entity = $event->getData();
            $form = $event->getForm();


            if ($entity->getId()) {
              $form->add('plainPassword', LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\RepeatedType'), array(
                  'required' => false,
                  'type' => LegacyFormHelper::getType('Symfony\Component\Form\Extension\Core\Type\PasswordType'),
                  'options' => array('translation_domain' => 'FOSUserBundle'),
                  'first_options' => array('label' => 'form.password'),
                  'second_options' => array('label' => 'form.password_confirmation'),
                  'invalid_message' => 'fos_user.password.mismatch',
              ));
            }
        });
    }

    public function getParent()
    {
        return RegistrationFormType::class;
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }
}


?>
