<?php

namespace tests\command;

use PHPUnit\Framework\TestCase;
use ddms\interfaces\command\Command;
use ddms\interfaces\ui\UserInterface;
use ddms\abstractions\command\AbstractDDMS;
use ddms\abstractions\ui\AbstractUserInterface;
use ddms\abstractions\command\AbstractCommand;

final class AbstractDDMSTest extends TestCase
{

    private const MOCK_COMMAND_UI_OUTPUT = 'Testing';

    public function testRunCommandReturnsValueMatchingValueReturnedOnIndependantCallToSpecifiedCommandsRunMethod(): void
    {
        $this->assertEquals(
            $this->getMockCommand()->run($this->getMockUserInterface(), $this->getMockCommand()->prepareArguments([])),
            $this->getMockDDMS()->runCommand($this->getMockUserInterface(), $this->getMockCommand(), [])
        );
    }

    public function testRunCommandOutputMatchesOutputOfIndpendantCallToSpecifiedCommandsRunMethod(): void
    {
        $this->expectOutputString(self::MOCK_COMMAND_UI_OUTPUT . self::MOCK_COMMAND_UI_OUTPUT);
        $this->getMockCommand()->run($this->getMockUserInterface(), $this->getMockCommand()->prepareArguments($this->mockArgvArrayWithFlagsAndOptions()));
        $this->getMockDDMS()->runCommand($this->getMockUserInterface(), $this->getMockCommand(), $this->mockArgvArrayWithFlagsAndOptions());
    }

    /**
     * @return array<mixed>
     */
    private function mockArgvArrayWithFlagsAndOptions(): array
    {
        return ['mockOutput', '--output', self::MOCK_COMMAND_UI_OUTPUT];
    }

    private function getMockUserInterface(): AbstractUserInterface
    {
        return $this->getMockBuilder(AbstractUserInterface::class)
            ->getMockForAbstractClass();

    }

    private function getMockCommand(): AbstractCommand
    {

        return new MockCommand();

    }

    private function getMockDDMS(): AbstractDDMS
    {
        return $this->getMockBuilder(AbstractDDMS::class)
            ->getMockForAbstractClass();
    }

}

final class MockCommand extends AbstractCommand implements Command
{

    public function run(UserInterface $userInterface, array $preparedArguments = ['flags' => [], 'options' => []]): bool
    {
        if(in_array('mockOutput', $preparedArguments['options']) && isset($preparedArguments['flags']['output'][0])) {
            $userInterface->showMessage($preparedArguments['flags']['output'][0]);
        }
        return true;
    }

}
