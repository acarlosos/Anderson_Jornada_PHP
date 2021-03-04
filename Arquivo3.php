<?php
require_once 'ArquivoBase.php';

/**
 * 
 */
class Arquivo3 extends ArquivoBase
{
	
	private $files;
	
	function __construct()
	{
		$this->files = array_diff(scandir('script'), array('..', '.', '.DS_Store'));

	}

	public function run()
	{
		$master = [];
		foreach ($this->files as $key => $f) {
			$data = file('script/'.$f);
			$master = array_merge($master, $data);
			unlink('script/'.$f);
			
		}
		$this->writeSQLFULL( 'update_', $master, 'update', true );
		return 'Sucesso';
	}

	private function unificar($data)
	{
		$content = [];

		foreach ($data as $line) {
			var_dump($line); die;
			
		}
		
		return $script;
	}


}


$a = new Arquivo3();
var_dump($a->run());die;

