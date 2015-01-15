<?php

namespace AEMR\Bundle\MarketResearchBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class GeographyType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('code')
            ->add('code_3')
            ->add('numerical_code')
            ->add('name')
            ->add('type')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AEMR\Bundle\MarketResearchBundle\Entity\Geography'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'aemr_bundle_marketresearchbundle_geography';
    }
}
