<?php

namespace Sebaks\ZendMvcControllerTest;

use Zend\ServiceManager\ServiceLocatorInterface;
use Sebaks\ZendMvcController\CriteriaValidatorFactory;
use Sebaks\Controller\ValidatorInterface;

class CriteriaValidatorFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateService()
    {
        $serviceLocator = $this->prophesize(ServiceLocatorInterface::class);
        $app = $this->prophesize('\Zend\Mvc\Application');
        $event = $this->prophesize('Zend\Mvc\MvcEvent');
        $routeMatch = $this->prophesize('\Zend\Mvc\Router\Http\RouteMatch');
        $criteriaValidator = $this->prophesize(ValidatorInterface::class);

        $serviceLocator->get('Application')->willReturn($app->reveal());

        $event->getRouteMatch()->willReturn($routeMatch->reveal());

        $app->getMvcEvent()->willReturn($event->reveal());

        $routeMatch->getParam('criteriaValidator')->willReturn('Some\CriteriaValidator');
        $serviceLocator->get('Some\CriteriaValidator')->willReturn($criteriaValidator->reveal());

        $factory = new CriteriaValidatorFactory();

        $service = $factory->createService($serviceLocator->reveal());

        $this->assertEquals($criteriaValidator->reveal(), $service);
    }
}
