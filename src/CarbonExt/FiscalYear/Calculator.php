<?php
/**
 * Carbon Extension: Fiscal Year (FY)
 * @license GPLv2
 * @author Justin Rovang <generate@itnobody.com>
 */

namespace CarbonExt\FiscalYear;

use Carbon\Carbon;

/**
 * An extension that utilizes the Carbon DateTime object to determine the fiscal year (FY) for a given date.
 */
class Calculator {

    /**
     * @var int FY Start month
     */
    public int $month;

    /**
     * @var int FY start day
     */
    public int $day;

    /**
     * @param int $m FY Start month
     * @param int $d FY start day
     */
    public function __construct(int $m = 1, int $d = 1) {
        $this->month = $m;
        $this->day = $d;
    }

    /**
     * Get the FY end date
     *
     * @param Carbon $dt Date to determine FY for
     *
     * @return Carbon Carbon instance set to the end of the FY for the input
     */
    public function get(?Carbon $dt = null): Carbon {

        if ($dt === null) {
            $dt = new Carbon();
        }

        /* Disregard times */
        $dt->setTime(0, 0, 0);

        /* FY is based on the -end- of the FY, thus we will work backward to determine if we need to 'rollup' the FY
        from the input year */
        $fyStart = Carbon::create($dt->year, $this->month, $this->day, 0, 0, 0);
        $fyEnd = clone $fyStart;

        $fyEnd->addYear()->subDay();

        if (!$dt->between($fyStart, $fyEnd, true)) {
            $fyEnd->setYear($dt->year);
        }

        return $fyEnd;
    }
}
