<?php

namespace AEMR\Bundle\MarketResearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GeoIndicatorType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('name')
            ->add('geo_type')
            ->add('value_type')
            ->add('periodicity')
            ->add('base_period')
            ->add('status')
            ->add('source')
            ->add('aggregation_method')
            ->add('description')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AEMR\Bundle\MarketResearchBundle\Entity\GeoIndicator'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'geoindicator';
    }
}
