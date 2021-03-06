<?php

namespace tests\ui;

use PHPUnit\Framework\TestCase;
use ddms\interfaces\ui\UserInterface;
use ddms\abstractions\ui\AbstractUserInterface;

final class AbstractUserInterfaceTest extends TestCase
{

    public function testShowMessageOutputsSpecifiedMessage(): void {
        $message = 'Abstract User Interface' . rand(1000, PHP_INT_MAX);;
        $ui = $this
            ->getMockBuilder(AbstractUserInterface::class)
            ->getMockForAbstractClass();

        $this->expectOutputString($message);
        $ui->showMessage($message);
    }

}
