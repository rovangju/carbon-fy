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

}
