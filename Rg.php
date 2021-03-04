<?php

$parser = new Parser('CargaRg.csv');
// $parser->execute();
$parser->selectScript();


/**
 * Gerar script para atualizar o banco de dados
 */
class Parser  
{
	private $file;
	
	function __construct($file = 'CargaRg.csv')
	{
		$this->file = $file;
	}

	public function selectScript()
	{
		$data = $this->loadFile();
		$cnpjPessoaId = $this->writeScriptSelect($data);
		$script = $this->writeSelect($cnpjPessoaId, $data);


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

	

	public function execute()
	{
		echo ("##### INICIO ##### <br>");
		$data = $this->loadFile();

		$scripts = $this->writeScript($data);
		$ok = $this->write($scripts);


	}

	private function loadFile() : array
	{
		echo ("##### CARREGAR ARQUIVO ##### <br>");
		return file($this->file);
	}

	private function writeScript(array $data)
	{
		echo ("##### ESCREVENDO SCRIPT ##### <br>");
		$scripts = [];
		array_shift($data);
		$datas = array_chunk($data, 2);

		foreach ($datas as $key => $data) {
			echo ("##### ESCREVENDO SCRIPT {$key} ##### <br>");
			foreach ($data as $key => $line) {
				$line = explode(';', $line);
				$lenght = strlen(trim($line[1])) <= 11 ? 11 : 14;
				$cnpj = str_pad(trim($line[1]), $lenght, '0', STR_PAD_LEFT);
				$result = $this->select($cnpj);
				if(count($result)){
					$PessoaID = $result[0]['PessoaID'];
					$rg = trim($line[4]);
					$scripts[$cnpj] = "UPDATE B004_Pessoas P SET P.IE ='{$rg}' WHERE P.PessoaId ='{$PessoaID}';";
				}
			}
			var_dump($scripts); die;
		}
		

		return $scripts;
	}

	private function write($scripts)
	{
		echo ("##### ESCREVENDO ARQUIVO ##### <br>");
		ksort($scripts);
		$file = fopen('script_update_' . date("d_m_Y_h_i_s") . '.sql', "a+");
		foreach ($scripts as $line) {
			fwrite($file, $line . PHP_EOL);
		}
		fclose($file);
	}

	private function writeScriptSelect(array $datas)
	{
		
		$scripts = [];
		array_shift($datas);
		$datas = array_chunk($datas, 10000);
		$result = [];
		foreach($datas as $data) {
			$cnpjs = [];
			foreach ($data as $key => $line) {
				$line = explode(';', $line);
				$cnpj = $this->getCnpj($line);
				$cnpjs[] = "'".$cnpj."'";
			}
			$result[] = $this->select($cnpjs);
		}
		return $result;
	}

	private function writeSelect(array $CnpjPessoaId, array $data)
	{
		$scripts = [];
		array_shift($data);
		
		foreach ($data as $key => $line) {
			$line = explode(';', $line);
			$cnpj = $this->getCnpj($line);
			$result = $this->select($cnpj);
			if(count($result)){
				$PessoaID = $cnpjPessoaId[$cnpj]['PessoaID'];
				var_dump($PessoaID); die;
				$rg = trim($line[4]);
				$scripts[$cnpj] = "UPDATE B004_Pessoas P SET P.IE ='{$rg}' WHERE P.PessoaId ='{$PessoaID}';";
			}
		}

		return $scripts;
	}

	private function getCnpj($line)
	{
		$lenght = strlen(trim($line[1])) <= 11 ? 11 : 14;
		return str_pad(trim($line[1]), $lenght, '0', STR_PAD_LEFT);
	}


}