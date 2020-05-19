<?php

declare(strict_types=1);

namespace PayHero\Calculator\Service;

/**
 * Class WeekManager.
 *
 * Week Datetime logic
 */
class WeekManager
{
    /**
     * Indicates whether two date strings belong to the same week.
     */
    public static function checkIsSameWeek(string $firstDateString, string $secondDateString): bool
    {
        $firstDate = (int) strtotime($firstDateString);
        $secondDate = (int) strtotime($secondDateString);

        $firstDateWeekNumber = (int) date('W', $firstDate);
        $firstDateMonthNumber = (int) date('m', $firstDate);
        $firstDateYearNumber = (int) date('Y', $firstDate);

        $secondDateWeekNumber = (int) date('W', $secondDate);
        $secondDateMonthNumber = (int) date('m', $secondDate);
        $secondDateYearNumber = (int) date('Y', $secondDate);

        if ($firstDateWeekNumber === $secondDateWeekNumber) {
            if ($firstDateYearNumber === $secondDateYearNumber) {
                return true;
            }
        }

        if ($firstDateYearNumber + 1 === $secondDateYearNumber) {
            if (($firstDateMonthNumber === 12) && ($secondDateMonthNumber) === 1) {
                if ($secondDateWeekNumber === $firstDateWeekNumber) {
                    return true;
                }

                $numberOfTheLastWeekOfPreviousYear =
                    date('W', strtotime('December 28th '.$firstDateYearNumber));

                if ($firstDateWeekNumber === $numberOfTheLastWeekOfPreviousYear) {
                    if ($secondDateWeekNumber === 01) {
                        // Confirm that it is indeed the same week
                        // and not two different ones right after another.
                        $firstDateWeekMondayDay = date('d',
                            strtotime('monday this week', $firstDate));
                        $secondDateWeekSundayDay = date('d',
                            strtotime('sunday this week', $secondDate));

                        if ($firstDateWeekMondayDay + $secondDateWeekSundayDay - 30 === 7) {
                            return true;
                        }
                    }
                }
            }
        }

        return false;
    }
}
