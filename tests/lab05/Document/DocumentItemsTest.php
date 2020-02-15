<?php
declare(strict_types=1);

use Lab05\Document\DocumentItemInterface;
use Lab05\Document\DocumentItems;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DocumentItemsTest extends TestCase
{
    /** @var DocumentItems */
    private $documentItems;
    /** @var DocumentItemInterface|MockObject */
    private $item;

    public function testWhatDocumentItemsIsEmpty(): void
    {
        $this->assertEquals(0, $this->documentItems->getCountItems());
    }

    public function testAddWithInvalidPosition(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->documentItems->add($this->item, 1);
    }

    public function testAddItemInEndWithGetItemsCount(): void
    {
        $this->documentItems->add($this->item);
        $this->assertEquals(1, $this->documentItems->getCountItems());
        $this->documentItems->add($this->item);
        $this->assertEquals(2, $this->documentItems->getCountItems());
    }

    public function testDeleteItemAfterAdd(): void
    {
        $this->documentItems->add($this->item);
        $this->documentItems->deleteItem(0);
        $this->assertEquals(0, $this->documentItems->getCountItems());
    }

    public function testAddedItemsInPositionIsEqualsGetItems(): void
    {
        $first = $this->createMock(DocumentItemInterface::class);
        $second = $this->createMock(DocumentItemInterface::class);
        $third = $this->createMock(DocumentItemInterface::class);

        $this->documentItems->add($first, 0);
        $this->documentItems->add($third, 1);
        $this->documentItems->add($second, 1);

        $this->assertTrue($first === $this->documentItems->getItem(0));
        $this->assertTrue($second === $this->documentItems->getItem(1));
        $this->assertTrue($third === $this->documentItems->getItem(2));

    }

    public function testDeleteItemFromPositionIsCorrectly(): void
    {
        $first = $this->createMock(DocumentItemInterface::class);
        $second = $this->createMock(DocumentItemInterface::class);
        $third = $this->createMock(DocumentItemInterface::class);

        $this->documentItems->add($first);
        $this->documentItems->add($second);
        $this->documentItems->add($third);

        $this->documentItems->deleteItem(1);

        $this->assertTrue($first === $this->documentItems->getItem(0));
        $this->assertTrue($third === $this->documentItems->getItem(1));

    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->documentItems = new DocumentItems();
        $this->item = $this->createMock(DocumentItemInterface::class);
    }
}