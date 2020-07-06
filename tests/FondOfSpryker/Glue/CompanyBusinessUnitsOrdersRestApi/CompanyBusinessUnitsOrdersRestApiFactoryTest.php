<?php

namespace FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi;

use Codeception\Test\Unit;
use FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClient;
use FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\Processor\Order\OrderReader;
use Spryker\Client\Kernel\AbstractClient;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;

class CompanyBusinessUnitsOrdersRestApiFactoryTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiClient
     */
    protected $clientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
     */
    protected $restResourceBuilderMock;

    /**
     * @var \FondOfSpryker\Glue\CompanyBusinessUnitsOrdersRestApi\CompanyBusinessUnitsOrdersRestApiFactory
     */
    protected $companyBusinessUnitsOrdersRestApiFactory;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->clientMock = $this->getMockBuilder(CompanyBusinessUnitsOrdersRestApiClient::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->restResourceBuilderMock = $this->getMockBuilder(RestResourceBuilderInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiFactory = new class ($this->clientMock, $this->restResourceBuilderMock) extends CompanyBusinessUnitsOrdersRestApiFactory {
            /**
             * @var \Spryker\Client\Kernel\AbstractClient
             */
            protected $client;

            /**
             * @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            protected $restResourceBuilder;

            /**
             * @param \Spryker\Client\Kernel\AbstractClient $client
             * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
             */
            public function __construct(
                AbstractClient $client,
                RestResourceBuilderInterface $restResourceBuilder
            ) {
                $this->client = $client;
                $this->restResourceBuilder = $restResourceBuilder;
            }

            /**
             * @return \Spryker\Client\Kernel\AbstractClient
             */
            public function getClient(): AbstractClient
            {
                return $this->client;
            }

            /**
             * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface
             */
            public function getResourceBuilder(): RestResourceBuilderInterface
            {
                return $this->restResourceBuilder;
            }
        };
    }

    /**
     * @return void
     */
    public function testCreateOrderReader(): void
    {
        $this->assertInstanceOf(
            OrderReader::class,
            $this->companyBusinessUnitsOrdersRestApiFactory->createOrderReader()
        );
    }
}
