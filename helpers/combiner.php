<?php

class combiner
{
  public function __construct($args)
  {
    foreach ($args as $arg)
      $this->combine($arg);
  }
  
  /* 
    Combines files in a folder to a combined file. Will make sure that if any 
    adjustments are made to any of the files it will recombine so it is really
    easy to use.
  */
  private function combine($type)
  {
    $path     = 'theme/'.$type;
    $combined = $path.'/combined.'.$type; 
    $files = get_files($path, array('combined.'.$type));

    if (file_exists($combined))
    { 
      $time_stamp = filemtime($combined);
      $recombine  = false;
      
      foreach ($files as $file)
        if (filemtime($path.'/'.$file) > $time_stamp)
        {
          $recombine = true;
          break;
        }
        
      if (! $recombine)
        return true;
    }
    
    $content = "/* Theme combined $type */";
    
    foreach ($files as $file)
      $content .= file_get_contents($path.'/'.$file);
      
    $f = fopen("$path/combined.$type", 'w');
    fwrite($f, compress($content));
    fclose($f);
  }
}
?>