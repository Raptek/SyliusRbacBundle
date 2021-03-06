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
use Sylius\Bundle\RbacBundle\Form\Type\PermissionEntityType;
use Sylius\Bundle\RbacBundle\Form\Type\ResourceChoiceType;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Metadata\MetadataInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Arnaud Langlade <arn0d.dev@gmail.com>
 */
final class PermissionEntityTypeSpec extends ObjectBehavior
{
    function let(MetadataInterface $metadata)
    {
        $this->beConstructedWith($metadata);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PermissionEntityType::class);
    }

    function it_is_a_form()
    {
        $this->shouldHaveType(ResourceChoiceType::class);
    }

    function it_has_options(OptionsResolver $resolver, $metadata)
    {
        $metadata->getDriver()->willReturn(SyliusResourceBundle::DRIVER_DOCTRINE_ORM);
        $resolver->setDefaults(Argument::withKey('class'))->shouldBeCalled()->willReturn($resolver);
        $resolver->setNormalizer('class', Argument::type('callable'))->shouldBeCalled()->willReturn($resolver);
        $resolver->setDefaults(Argument::withKey('query_builder'))->shouldBeCalled()->willReturn($resolver);

        $this->configureOptions($resolver);
    }
}
