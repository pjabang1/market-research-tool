<?php

namespace AEMR\Bundle\MarketResearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GeoModelParameterIndicatorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('geomodelparameter_id')
            ->add('geoindicator_id')
            ->add('weight')
            ->add('aggregation_type')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AEMR\Bundle\MarketResearchBundle\Entity\GeoModelParameterIndicator'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'geomodelparameterindicator';
    }
}
