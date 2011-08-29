<?php
  class Template {
    protected $file;
    protected $values = array();

    public function __construct ($file) {
      $this->file = $file;
    }

    public function set ($key, $value) {
      $this->values[$key] = $value;
    }

    public function output () {
      try {
        if (!file_exists($this->file)) {
          throw new Exception ("Couldn't find the template file: $this->file");
        }

        $output = file_get_contents($this->file);

        foreach ($this->values as $key=>$value) {
          if (is_array($value)) { // if its a collection of values to replace (loop)
            $output = $this->getOutput($output,$key,$value);
          } else {
            $output = str_replace("[@$key]", $value, $output); // or a single value to replace
            $output = str_replace("[/@$key]", "", $output); // just in case - make sure to clean up templating statements
          }
        }

        return $output;
      } catch (Exception $e) {
        echo $e->getMessage(), "\n";
      }
    }

    private function getOutput ($output, $key, $value) {
      $startpos = strpos($output, "[@$key]");
      $endpos = strpos($output, "[/@$key]");
      $originalBlock = substr($output, $startpos, ($endpos + strlen("[/@$key]")) - $startpos);  
      $newBlocks = '';
      if (!$endpos) {
        throw new Exception ("Missing ending statement for [@$key]. Should look like [/@$key]");
      }

      $blockTemplate = $this->getStringBetween($output, "[@$key]", "[/@$key]");
      
      // loop through the values and build a new string
      foreach ($value as $array){ // $value is each new block, $array are the values that go in each block
        $tempBlock = $blockTemplate;
        foreach($array as $subKey=>$subValue) {
          if (is_array($subValue)) {
            $tempBlock = $this->getOutput($tempBlock, $subKey, $subValue);
          } else {
            $tempBlock = substr_replace($tempBlock, $subValue, strpos($tempBlock, "[@$subKey]"), strlen("[@$subKey]"));
            $tempBlock = str_replace("[/@$subKey]", '', $tempBlock);
          }
        }
        $newBlocks .= $tempBlock;
      }

      $output = str_replace($originalBlock, $newBlocks, $output);
      return $output;
    }

    private function getStringBetween ($string, $start, $end) {
      $string = " ".$string;
      $ini = strpos($string,$start);
      $ini += strlen($start);
      $len = strpos($string,$end,$ini) - $ini;
      return substr($string,$ini,$len);
    }
  }
