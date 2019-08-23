<?php

namespace BaseApplication\Excel;

use PHPExcel;
use PHPExcel_Exception;
use PHPExcel_IOFactory;

/**
 * Class BaseExcelExport
 * @package BaseApplication\Excel
 */
abstract class BaseExcelExport implements ExcelExportInterface
{
    const FIRST_SHEET = 0;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var PHPExcel
     */
    protected $phpExcel;

    /**
     * @var array
     */
    protected $config;

    /**
     * @var array
     */
    protected $cells;

    /**
     * BaseExcelExport constructor.
     * @param array $config
     * @throws PHPExcel_Exception
     */
    public function __construct(array $config)
    {
        $this->config = $config;

        $this->phpExcel = new PHPExcel();

        $this->phpExcel->getProperties()->setCreator('sistema Neodent')
            ->setLastModifiedBy('sistema Neodent')
            ->setTitle('Office 2007 XLS Document')
            ->setSubject('Office 2007 XLS Document')
            ->setDescription('Office 2007 XLS Document')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('Result file');

        if (! empty($this->cells)) {
            foreach ($this->cells as $key => $title) {
                $this->phpExcel->setActiveSheetIndex(self::FIRST_SHEET)
                    ->setCellValue($this->getNameFromNumber($key) . '1', $title);
            }
        }
    }

    /**
     * Define o nome do arquivo
     *
     * @param $filename
     * @return ExcelExportInterface
     */
    public function setFilename($filename): ExcelExportInterface
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Realiza o download do arquivo
     *
     * @return mixed
     * @throws PHPExcel_Exception
     */
    public function downloadFile()
    {
        $this->phpExcel->setActiveSheetIndex(self::FIRST_SHEET);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $this->filename . '.xlsx"');
        header('Cache-Control: max-age=0');

        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0
        $objWriter = PHPExcel_IOFactory::createWriter($this->phpExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    /**
     * @param $num
     * @return string
     */
    protected function getNameFromNumber($num)
    {
        $numeric = $num % 26;
        $letter = chr(65 + $numeric);
        $num2 = intval($num / 26);
        if ($num2 > 0) {
            return $this->getNameFromNumber($num2 - 1) . $letter;
        } else {
            return $letter;
        }
    }
}
