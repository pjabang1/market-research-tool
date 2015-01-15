<?php

namespace AEMR\Bundle\MarketResearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GeoModelType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('algorithm_code')
            ->add('description')
            ->add('geogroup_id')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AEMR\Bundle\MarketResearchBundle\Entity\GeoModel'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'aemr_bundle_marketresearchbundle_geomodel';
    }
}
