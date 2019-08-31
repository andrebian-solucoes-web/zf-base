<?php declare(strict_types=1);

namespace BaseApplication\View\Helper;

use DateInterval;
use DateTime;
use Exception;

/**
 * Class NextNetworkDayViewHelper
 * @package BaseApplication\View\Helper
 */
class NextNetworkDayViewHelper
{
    /**
     * @param $inputDate
     * @param null $pattern
     * @return DateTime|string
     * @throws Exception
     */
    public function __invoke($inputDate, $pattern = null)
    {
        if (is_string($inputDate)) {
            $inputDate = new DateTime(str_replace('/', '-', $inputDate));
        }

        $result = $this->nextNetworkDay($inputDate);

        if ($pattern) {
            return $result->format($pattern);
        }

        return $result;
    }

    /**
     * @param DateTime $inputDate
     * @return DateTime
     * @throws Exception
     */
    public function nextNetworkDay(DateTime $inputDate): DateTime
    {
        $daysToIncrement = '1';
        if ($inputDate->format('w') == 6) {
            $daysToIncrement = '2';
        }

        $inputDate->add(new DateInterval('P' . $daysToIncrement . 'D'));

        return $inputDate;
    }
}
