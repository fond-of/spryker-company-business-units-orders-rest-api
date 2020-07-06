<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Controller;

use Codeception\Test\Unit;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiFactory;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order\OrderReaderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class CompanyBusinessUnitsOrdersResourceControllerTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiFactory
     */
    protected $companyBusinessUnitsOrdersRestApiFactory;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order\OrderReaderInterface
     */
    protected $orderReaderMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface
     */
    protected $restRequestMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    protected $restResponseMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Controller\CompanyBusinessUnitsOrdersResourceController
     */
    protected $companyBusinessUnitsOrdersResourceController;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->companyBusinessUnitsOrdersRestApiFactory = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderReaderMock = $this->getMockBuilder(OrderReaderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restRequestMock = $this->getMockBuilder(RestRequestInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResponseMock = $this->getMockBuilder(RestResponseInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersResourceController = new class ($this->companyBusinessUnitsOrdersRestApiFactory) extends CompanyBusinessUnitsOrdersResourceController {
            /**
             * @var \Spryker\Glue\Kernel\AbstractFactory
             */
            protected $factory;

            /**
             *  constructor.
             *
             * @param \Spryker\Glue\Kernel\AbstractFactory $factory
             */
            public function __construct(AbstractFactory $factory)
            {
                $this->factory = $factory;
            }

            /**
             * @return \Spryker\Glue\Kernel\AbstractFactory
             */
            public function getFactory(): AbstractFactory
            {
                return $this->factory;
            }
        };
    }

    /**
     * @return void
     */
    public function testGetAction(): void
    {
        $this->companyBusinessUnitsOrdersRestApiFactory->expects($this->atLeastOnce())
            ->method('createOrderReader')
            ->willReturn($this->orderReaderMock);

        $this->orderReaderMock->expects($this->atLeastOnce())
            ->method('findOrders')
            ->with($this->restRequestMock)
            ->willReturn($this->restResponseMock);

        $restResponse = $this->companyBusinessUnitsOrdersResourceController->getAction($this->restRequestMock);

        $this->assertEquals($this->restResponseMock, $restResponse);
    }
}
