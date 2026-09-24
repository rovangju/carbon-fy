<?php
/**
 * Carbon Extension: Fiscal Year (FY)
 * @license GPLv2
 * @author Justin Rovang <generate@itnobody.com>
 */

use CarbonExt\FiscalYear\Calculator;
use Carbon\Carbon;
use PHPUnit\Framework\Attributes\DataProvider;

class FYTest extends TestBase {

    public function testDefaults() {
        $this->assertSame(
            1,
            $this->fresh->day
        );

        $this->assertSame(
            7,
            $this->fresh->month
        );
    }

    public static function data(): array {
        return array(

            /* Within the actual year year */
            /*    M, D, 'test value', 'expected  ' */
            array(1, 1, '2015-01-01', '2015-12-31'),
            array(1, 1, '2015-01-02', '2015-12-31'),

            array(7, 1, '2015-01-01', '2015-06-30'),
            array(7, 1, '2015-06-29', '2015-06-30'),

            /* Actual year + 1 */
            /*    M, D, 'test value', 'expected  ' */
            array(7, 1, '2015-07-01', '2016-06-30'),
            array(7, 1, '2015-07-01', '2016-06-30'),
            array(12, 30, '2015-12-31', '2016-12-29')
        );
    }

    #[DataProvider('data')]
    public function testGet($fyM, $fyD, $test, $expected) {

        $fy = new Calculator($fyM, $fyD);

        $dt = $fy->get(
            new Carbon($test)
        );

        $this->assertSame(
            $expected,
            $dt->format('Y-m-d')
        );
    }

    public static function startData(): array {
        return array(

            /*    M, D, 'test value', 'expected  ' */
            array(1, 1, '2015-01-01', '2015-01-01'),
            array(1, 1, '2015-12-31', '2015-01-01'),

            array(7, 1, '2015-01-01', '2014-07-01'),
            array(7, 1, '2015-06-30', '2014-07-01'),
            array(7, 1, '2015-07-01', '2015-07-01'),
            array(7, 1, '2015-12-31', '2015-07-01'),

            array(12, 30, '2015-12-31', '2015-12-30'),
            array(12, 30, '2015-01-01', '2014-12-30')
        );
    }

    #[DataProvider('startData')]
    public function testGetStart($fyM, $fyD, $test, $expected) {

        $fy = new Calculator($fyM, $fyD);

        $dt = $fy->getStart(
            new Carbon($test)
        );

        $this->assertSame(
            $expected,
            $dt->format('Y-m-d')
        );
    }

    public function testGetDoesNotMutateInput() {

        $input = new Carbon('2015-03-15 13:45:30');

        $this->fresh->get($input);

        $this->assertSame(
            '2015-03-15 13:45:30',
            $input->format('Y-m-d H:i:s')
        );
    }

    public function testGetStartDoesNotMutateInput() {

        $input = new Carbon('2015-03-15 13:45:30');

        $this->fresh->getStart($input);

        $this->assertSame(
            '2015-03-15 13:45:30',
            $input->format('Y-m-d H:i:s')
        );
    }

}
