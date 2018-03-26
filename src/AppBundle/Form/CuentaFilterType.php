<?php
// ItemFilterType.php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;

class CuentaFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('apellido', Filters\TextFilterType::class, array('label' => 'Apellido', 'condition_pattern' => FilterOperands::STRING_CONTAINS,));
        $builder->add('nombre', Filters\TextFilterType::class, array('label' => 'Nombre', 'condition_pattern' => FilterOperands::STRING_CONTAINS,));
        $builder->add('dni', Filters\TextFilterType::class, array('label' => 'D.N.I.', 'condition_pattern' => FilterOperands::STRING_CONTAINS,));
        $builder->add('mail', Filters\TextFilterType::class, array('label' => 'Código de Cuenta', 'condition_pattern' => FilterOperands::STRING_CONTAINS,));
        $builder->add('jurisdiccion', Filters\EntityFilterType::class, array('class' => 'AppBundle\Entity\Jurisdiccion'));
    }

    public function getBlockPrefix()
    {
        return 'item_filter';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection'   => false,
            'validation_groups' => array('filtering') // avoid NotBlank() constraint-related message
        ));
    }
}
?>
