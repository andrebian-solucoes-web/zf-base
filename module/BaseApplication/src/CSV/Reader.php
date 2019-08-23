<?php

namespace BaseApplication\CSV;

use RuntimeException;

/**
 * Class Reader
 * @package BaseApplication\CSV
 */
class Reader
{
    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var array
     */
    private $data = [];

    /**
     * @param $csvLocation
     * @param int $startLine
     * @param string $delimiter
     * @return $this
     */
    public function readFile($csvLocation, $startLine = 0, $delimiter = ',')
    {
        if (! is_file($csvLocation)) {
            throw new RuntimeException('Invalid or not located CSV file');
        }

        if (! is_readable($csvLocation)) {
            throw new RuntimeException('CSV file not readable');
        }

        $handle = fopen($csvLocation, 'r');

        $this->processHeaders(fgetcsv($handle, 0, $delimiter));

        $this->data = [];

        for ($i = 0; $row = fgetcsv($handle, 0, $delimiter); ++$i) {
            if ($row) {
                if ($i >= $startLine) {
                    $this->data[] = $this->bindKeyValues($row);
                }
            }
        }

        fclose($handle);

        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param $row
     * @return array
     */
    private function bindKeyValues($row)
    {
        $result = [];
        foreach ($this->headers as $index => $column) {
            if (isset($row[$index])) {
                $result[trim($column)] = trim($row[$index]);
            }
        }

        return $result;
    }

    /**
     * @param array|null $data
     */
    private function processHeaders(?array $data)
    {
        foreach ($data as $d) {
            array_push($this->headers, trim($d));
        }
    }
}
