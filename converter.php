<?php

class converter
{
    public $is_success;
    function create_csv($xml_file_input, $csv_file_output)
    {
        $csv_data = "";
        if (file_exists($xml_file_input)) {
            if (!$xml = simplexml_load_file($xml_file_input)) {
                return $this->is_success = false;
            }
        } else {
            return $this->is_success = false;
        }

        $output_file = fopen($csv_file_output, 'w');
        $header = false;
        foreach ($xml as $key => $value) {
            if (!$header) {
                if (!fputcsv($output_file, array_keys(get_object_vars($value)))) {
                    return $this->is_success = false;
                }
                $header = true;
            }
            if (!fputcsv($output_file, get_object_vars($value))) {
                return $this->is_success = false;
            }
        }
        fclose($output_file);
        return $this->is_success = true;
    }
}

$converter = new Converter();
$converter->create_csv('sample.xml', 'sample.csv');

try {
    if ($converter->is_success) {
        echo 'The XML file has been converted to CSV';
    } else {
        throw new Exception("was_not_converted");
    }
} catch (Exception $e) {
    echo "The XML file was not converted to CSV -> " . $e->getMessage();
}
