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
     * Get the FY start date
     *
     * @param Carbon $dt Date to determine FY for
     *
     * @return Carbon Carbon instance set to the start of the FY for the input
     */
    public function getStart(?Carbon $dt = null): Carbon {

        if ($dt === null) {
            $dt = new Carbon();
        }

        /* Disregard times (work on a copy so the input is not mutated) */
        $dt = clone $dt;
        $dt->setTime(0, 0, 0);

        $fyStart = Carbon::create($dt->year, $this->month, $this->day, 0, 0, 0);

        /* If the input date precedes the FY start of its calendar year, it belongs to the FY that began the
        prior year */
        if ($dt->lt($fyStart)) {
            $fyStart->setYear($dt->year - 1);
        }

        return $fyStart;
    }

    /**
     * Get the FY end date
     *
     * @param Carbon $dt Date to determine FY for
     *
     * @return Carbon Carbon instance set to the end of the FY for the input
     */
    public function get(?Carbon $dt = null): Carbon {
        return (clone $this->getStart($dt))->addYear()->subDay();
    }
}
