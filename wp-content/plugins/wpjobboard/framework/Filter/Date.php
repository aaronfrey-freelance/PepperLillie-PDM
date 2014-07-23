<?php
/**
 * Description of Date
 *
 * @author greg
 * @package 
 */

class Daq_Filter_Date implements Daq_Filter_Interface
{
    private $_format = null;
    
    public function __construct($format) 
    {
        $this->_format = $format;
    }
    
    public function filter($value)
    {
        $ts = current_time("timestamp");
        $offset = str_replace(array("+", "-"), array("-", "+"), get_option("gmt_offset"))." hours";

        $date = date_create_from_format($this->_format, $value);
        $date->setTime(date("H", $ts), date("i", $ts), date("s", $ts));
        $date->modify($offset);

        return $date->format("Y-m-d");
    }
}

?>