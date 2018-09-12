<?php
/**
 * Created by PhpStorm.
 * User: andrebian - Andre Cardoso https://github.com/andrebian
 * Date: 11/09/18
 * Time: 23:10
 */

namespace BaseApplication\Validator;

use DateInterval;
use DateTime;
use Zend\Validator\AbstractValidator;

/**
 * Class BirthDateValidator
 * @package BaseApplication\Validator
 */
class BirthDateValidator extends AbstractValidator
{
    const INVALID = 'birthDateInvalid';

    /**
     * @var DateTime
     */
    protected $dateCompare;

    /**
     * @var array
     */
    protected $messageTemplates = [
        self::INVALID => "Please provide a valid birth date",
    ];

    /**
     * BirthDateValidator constructor.
     * @param null $options
     * @throws \Exception
     */
    public function __construct($options = null)
    {
        $this->dateCompare = new DateTime();

        parent::__construct($options);

        if (isset($options['min_age'])) {
            $minAge = (int)$options['min_age'];
            $age = new DateInterval('P' . $minAge . 'Y');
            $this->dateCompare->sub($age);
        }
    }

    /**
     * @inheritdoc
     */
    public function isValid($value)
    {
        if ($value > $this->dateCompare) {
            $this->error(self::INVALID);
            return false;
        }

        return true;
    }
}
