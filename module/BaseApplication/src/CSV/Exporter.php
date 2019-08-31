<?php declare(strict_types=1);

namespace BaseApplication\CSV;

/**
 * Class Exporter
 * @package BaseApplication\CSV
 */
class Exporter
{
    /**
     * @var string
     */
    private $fileName;

    /**
     * @var array
     */
    private $data;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    /**
     * @param array $data
     * @return $this
     */
    public function setData(array $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     *
     */
    public function download()
    {
        $csv = tmpfile();

        fputcsv($csv, array_keys(reset($this->data)));
        foreach ($this->data as $row) {
            fputcsv($csv, $row);
        }

        rewind($csv);
        $fstat = fstat($csv);

        $now = gmdate("D, d M Y H:i:s");
        header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Last-Modified: {$now} GMT");
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $this->fileName . '";');
        header("Content-Length: " . $fstat['size']);
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Transfer-Encoding: binary");

        //output all remaining data on a file pointer
        fpassthru($csv);
        fclose($csv);

        exit(1);
    }
}
