<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace spec\Sylius\Bundle\RbacBundle\Form\Type;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Sylius\Bundle\RbacBundle\Form\EventSubscriber\AddParentFormSubscriber;
use Sylius\Bundle\RbacBundle\Form\Type\PermissionType;
use Sylius\Bundle\ResourceBundle\Form\EventSubscriber\AddCodeFormSubscriber;
use Sylius\Component\Rbac\Model\Permission;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\FormTypeInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Paweł Jędrzejewski <pawel@sylius.org>
 */
final class PermissionTypeSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(Permission::class, ['sylius']);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PermissionType::class);
    }

    function it_is_a_form_type()
    {
        $this->shouldImplement(FormTypeInterface::class);
    }

    function it_should_build_form_with_proper_fields(FormBuilder $builder)
    {
        $builder
            ->add('description', TextareaType::class, Argument::any())
            ->shouldBeCalled()
            ->willReturn($builder)
        ;

        $builder
            ->addEventSubscriber(Argument::type(AddCodeFormSubscriber::class))
            ->shouldBeCalled()
            ->willReturn($builder)
        ;

        $builder
            ->addEventSubscriber(Argument::type(AddParentFormSubscriber::class))
            ->shouldBeCalled()
            ->willReturn($builder)
        ;

        $this->buildForm($builder, []);
    }

    function it_should_define_assigned_data_class_and_validation_groups(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Permission::class,
                'validation_groups' => ['sylius'],
            ])
            ->shouldBeCalled()
        ;

        $this->configureOptions($resolver);
    }
}
