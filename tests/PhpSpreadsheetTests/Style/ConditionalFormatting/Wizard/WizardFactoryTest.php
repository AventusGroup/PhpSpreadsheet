<?php

namespace PhpOffice\PhpSpreadsheetTests\Style\ConditionalFormatting\Wizard;

use Exception;
use PhpOffice\PhpSpreadsheet\Style\ConditionalFormatting\Wizard;
use PHPUnit\Framework\TestCase;

class WizardFactoryTest extends TestCase
{
    /**
     * @var Wizard
     */
    protected $wizardFactory;

    protected function setUp(): void
    {
        $range = '$C$3:$E$5';
        $this->wizardFactory = new Wizard($range);
    }

    /**
     * @dataProvider basicWizardFactoryProvider
     */
    public function testBasicWizardFactory(string $ruleType, string $expectedWizard): void
    {
        $wizard = $this->wizardFactory->newRule($ruleType);
        self::assertInstanceOf($expectedWizard, $wizard);
    }

    public function basicWizardFactoryProvider(): array
    {
        return [
            'CellValue Wizard' => [Wizard::CELL_VALUE, Wizard\CellValue::class],
            'TextValue Wizard' => [Wizard::TEXT_VALUE, Wizard\TextValue::class],
            'Blanks Wizard' => [Wizard::BLANKS, Wizard\Blanks::class],
            'Blanks Wizard (NOT)' => [Wizard::NOT_BLANKS, Wizard\Blanks::class],
            'Errors Wizard' => [Wizard::ERRORS, Wizard\Errors::class],
            'Errors Wizard (NOT)' => [Wizard::NOT_ERRORS, Wizard\Errors::class],
            'Expression Wizard' => [Wizard::EXPRESSION, Wizard\Expression::class],
            'DateValue Wizard' => [Wizard::DATES_OCCURRING, Wizard\DateValue::class],
        ];
    }

    public function testWizardFactoryException(): void
    {
        $ruleType = 'Unknown';
        self::expectException(Exception::class);
        self::expectExceptionMessage('No wizard exists for this rule type');
        $this->wizardFactory->newRule($ruleType);
    }
}
