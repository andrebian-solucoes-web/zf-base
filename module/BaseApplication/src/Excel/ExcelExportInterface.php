<?php

namespace BaseApplication\Excel;

/**
 * Interface ExcelExportInterface
 * @package BaseApplication\Excel
 */
interface ExcelExportInterface
{
    /**
     * Recebe os dados para salvar no arquivo
     *
     * @param array $data
     * @return ExcelExportInterface
     */
    public function setData(array $data): ExcelExportInterface;

    /**
     * Define o nome do arquivo
     *
     * @param $filename
     * @return ExcelExportInterface
     */
    public function setFilename($filename): ExcelExportInterface;

    /**
     * Realiza o download do arquivo
     *
     * @return mixed
     */
    public function downloadFile();
}
