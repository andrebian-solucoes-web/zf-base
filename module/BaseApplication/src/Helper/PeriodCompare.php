<?php declare(strict_types=1);

namespace BaseApplication\Helper;

use DateInterval;
use DateTime;
use Exception;

/**
 * Class PeriodCompare
 * @package BaseApplication\Helper
 */
class PeriodCompare
{
    /**
     * @var DateTime
     */
    private $start;

    /**
     * @var DateTime
     */
    private $end;

    /**
     * PeriodCompare constructor.
     * @param DateTime $start
     * @param DateTime $end
     * @throws Exception
     */
    public function __construct(DateTime $start, DateTime $end)
    {
        $this->start = $start;
        $this->end = $end;

        $this->process();
    }

    /**
     * @return $this
     * @throws Exception
     */
    public function process()
    {
        $diff = date_diff($this->start, $this->end);
        $daysToSubtract = $diff->format('%a');

        $finalDate = clone $this->start;
        $finalDate = $finalDate->sub(new DateInterval('P1D'));
        $this->end = $finalDate;

        $initialDate = clone $finalDate;
        $initialDate->sub(new DateInterval('P' . $daysToSubtract . 'D'));
        $this->start = $initialDate;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getStart(): DateTime
    {
        return $this->start;
    }

    /**
     * @return DateTime
     */
    public function getEnd(): DateTime
    {
        return $this->end;
    }
}
