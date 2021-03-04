<?php

require_once 'ArquivoBase.php';

/**
 * 
 */
class Arquivo2 extends ArquivoBase
{
	private $files;
	private $tt = 0;
	
	function __construct()
	{
		$this->files = array_diff(scandir('processar'), array('..', '.', '.DS_Store'));

	}

	public function run()
	{
		$writeNot = [];
		foreach ($this->files as $key => $f) {
			$data = file('processar/'.$f);
			$script = $this->scriptUpdate($data);

			$script2 = $this->remover($script);
			if( isset ( $script2['update'] )) {
				$this->writeTxt($key . '_base', $script2['update'], 'script', true );	
			}
			
			unlink('processar/'.$f);
		}


		
		return 'Fim: ' . $this->tt . ' Localizados.<br> Não Localizados: ' . count($writeNot);
	}

	private function remover($script)
	{
		$data = file('CargaRg2.csv');
		$nScript = [];
		array_shift($data);
		foreach ($data as $line) {
			$line = explode(';', $line);
			$lenght = strlen(trim($line[1])) <= 11 ? 11 : 14;
			$cnpj = str_pad(trim($line[1]), $lenght, '0', STR_PAD_LEFT);
			if ( isset($script['update'][$cnpj])) {
				$nScript['update'][] = $script['update'][$cnpj];	
			}
			
		}
		return $nScript;
	}

	private function scriptUpdate($data)
	{
		$content = [];
		
		foreach ($data as $line) {
			$l = explode(';', $line);
			$content[$l[0]]['CNPJ'] = $l[0];
			$content[$l[0]]['IE'] = $l[1];
			
		}
		$cnpjs = $this->select(array_keys($content));
		$this->tt += count($cnpjs);
		$script = [];
		$script['not'] = [];
		$script['update'] = [];
		foreach ($cnpjs as $key => $value) {
			$RG = trim($content[$key]['IE']);
			$PessoaID = $cnpjs[$key]['PessoaID'];
			$CNPJ = $key;
			$script['update'][$key] = "UPDATE B004_Pessoas SET IE ='{$RG}' WHERE PessoaID ='{$PessoaID}' AND IE = '{$CNPJ}';";

			unset($content[$key]);
			
		}
		$faltantes = file('Faltantes.csv');
		$fails = [];
		array_shift($faltantes);
		foreach ($faltantes as $l) {
			$l = explode(',', $l);
			$fails[$l[1]] = $l[0];
		}
		foreach ($content as $key => $c ) {
			$RG = trim($content[$key]['IE']);
			$CNPJ = $key;
			$PessoaID = $fails[$CNPJ];
			$script['update'][$key] = "UPDATE B004_Pessoas SET IE ='{$RG}' WHERE PessoaID ='{$PessoaID}' AND IE = '{$CNPJ}';" ;
		}


		
		return $script;
	}

	public function select($cnpjs)
	{
		
		try {

			$lista = join(  ',', $cnpjs);
		  	$conn = new PDO("mysql:host=10.220.1.12;dbname=movida", "movida", "m3QQDgB8B,n,WLvPkLJ]r33C"); 
		    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $data =  $conn->query('SELECT CNPJ,PessoaID FROM B004_Pessoas WHERE CNPJ in (' . $lista.' )' );
		    $result = [];

		    foreach ($data as $key => $value) {
		    	$result[$value['CNPJ']]['CNPJ'] = $value['CNPJ'];
		    	$result[$value['CNPJ']]['PessoaID'] = $value['PessoaID'];
		    }
		    return $result;

		} catch(PDOException $e) {
		    echo 'ERROR: ' . $e->getMessage();
		}
	}

		
}


$a = new Arquivo2();
var_dump($a->run());die;