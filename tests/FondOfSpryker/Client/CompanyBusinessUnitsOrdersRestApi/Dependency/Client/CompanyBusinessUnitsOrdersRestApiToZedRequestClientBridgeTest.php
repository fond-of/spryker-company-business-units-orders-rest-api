<?php

namespace FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client;

use Codeception\Test\Unit;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;
use Spryker\Shared\Kernel\Transfer\TransferInterface;

class CompanyBusinessUnitsOrdersRestApiToZedRequestClientBridgeTest extends Unit
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected $zedRequestClientMock;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject|\Spryker\Shared\Kernel\Transfer\TransferInterface
     */
    protected $transferMock;

    /**
     * @var \FondOfSpryker\Client\CompanyBusinessUnitsOrdersRestApi\Dependency\Client\CompanyBusinessUnitsOrdersRestApiToZedRequestClientBridge
     */
    protected $companyBusinessUnitsOrdersRestApiToZedRequestClientBridge;

    /**
     * @return void
     */
    protected function _before(): void
    {
        parent::_before();

        $this->zedRequestClientMock = $this->getMockBuilder(ZedRequestClientInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->transferMock = $this->getMockBuilder(TransferInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->companyBusinessUnitsOrdersRestApiToZedRequestClientBridge = new CompanyBusinessUnitsOrdersRestApiToZedRequestClientBridge($this->zedRequestClientMock);
    }

    /**
     * @return void
     */
    public function testCall(): void
    {
        $url = '...';

        $this->zedRequestClientMock->expects($this->atLeastOnce())
            ->method('call')
            ->with($url, $this->transferMock)
            ->willReturn($this->transferMock);

        $transfer = $this->companyBusinessUnitsOrdersRestApiToZedRequestClientBridge->call($url, $this->transferMock);

        $this->assertEquals($this->transferMock, $transfer);
    }
}
