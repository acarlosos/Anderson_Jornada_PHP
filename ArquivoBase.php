<?php

/**
 * 
 */
class ArquivoBase 
{
	
	protected function loadFile() : array
	{
		return file($this->file);
	}

	protected function write($file, $lines, $dir = false, $sort )
	{
		if($sort){
			ksort($lines);	
		}

		if ($dir && !is_dir($dir)){
			mkdir($dir, 0700);
			$dir .= '/';
		}else if ($dir == false) {
			$dir = '';
		}else{
			$dir .= '/';
		}
		$file = fopen($dir . $file . date("d_m_Y_h_i_s") . '.sql', "a+");
		foreach ($lines as $line) {
			fwrite($file, $line . PHP_EOL);
		}
		fclose($file);
	}

	protected function writeTxt($file, $lines, $dir = false, $sort )
	{
		if($sort){
			ksort($lines);	
		}

		if ($dir && !is_dir($dir)){
			mkdir($dir, 0700);
			$dir .= '/';
		}else if ($dir == false) {
			$dir = '';
		}else{
			$dir .= '/';
		}
		$file = fopen($dir . $file . date("d_m_Y_h_i_s") . '.txt', "a+");
		foreach ($lines as $line) {
			fwrite($file, $line . PHP_EOL);
		}
		fclose($file);
	}
	protected function writeSQLFULL($file, $lines, $dir = false, $sort )
	{
		if($sort){
			ksort($lines);	
		}

		if ($dir && !is_dir($dir)){
			mkdir($dir, 0700);
			$dir .= '/';
		}else if ($dir == false) {
			$dir = '';
		}else{
			$dir .= '/';
		}
		$file = fopen($dir . $file . date("d_m_Y_h_i_s") . '.sql', "a+");
		foreach ($lines as $line) {
			fwrite($file, $line);
		}
		fclose($file);
	}
}