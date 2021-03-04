<?php

require_once 'ArquivoBase.php';
/**
 * Segmenta o Arquivo principal em varios para processamento
 */
class Arquivo1 extends ArquivoBase
{
	protected $file;
	
	function __construct($file = 'CargaRg.csv')
	{
		$this->file = $file;
	}
	
	public function run() {
		$data =  $this->loadFile();

		$files =  $this->getLines($data);
		
		foreach($files as $key => $lines)
		{
		 	$this->writeTxt($key . '_base', $lines, 'processar', true );
		}

		return 'Sucesso';
	}

	private function getLines(array $data)
	{
		$scripts = [];
		array_shift($data);
		$datas = array_chunk($data, 7000);

		$nFile= [];
		foreach ($datas as $file) {
			$nLines = [];
			foreach ($file as $key => $line) {
				$item = [];
				$line = explode(';', $line);
				$lenght = strlen(trim($line[1])) <= 11 ? 11 : 14;
				$cnpj = str_pad(trim($line[1]), $lenght, '0', STR_PAD_LEFT);
				$item[] = $cnpj ;
				$item[] = $line[4] ;
				$nLines[$cnpj] = join(';', $item);
				
			}
			$nFile[] = $nLines;
			
		}

		return $nFile;
	}
}

$a = new Arquivo1();
var_dump($a->run());die;