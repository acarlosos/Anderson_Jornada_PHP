<?php


$aula = new Aula4();

$pessoas = [
	38 => 'Antonio',
	23 => 'Anderson',
	65 => 'Andre',
];

$aula->podeIrWhile(10);
$aula->podeIrDoWhile(4);
$aula->podeIrFor(2);
$aula->podeIrForeach($pessoas);
$aula->ler('teste.txt');

class Aula4 
{
	public function podeIrWhile($idade = 1)
	{
		// ENQUANTO a idade for menor que 18 FAÇA.
		while( $idade < 18 ) {
			echo "Você não pode entrar na balada com " . $idade . " anos. <br>";
			$idade++;
		}
		echo "Seja bem vindo ao role.";
	}

	public function podeIrDoWhile($idade = 1)
	{
		// FAÇA ENQUANTO a idade for menor que 18
		
		do {
			echo "Você não pode entrar na balada com " . $idade . " anos. <br>";
			$idade++;

		}while($idade < 18);
		echo "Seja bem vindo ao role.";

	}

	public function podeIrFor($x = 5)
	{
		//FAÇA X vezes
		for($i=1 ; $i < $x ; $i++)
		{
			$this->podeIrWhile($i);
			echo "<br>###################<br>";
		}
	}

	
	public function podeIrForeach($pessoas)
	{
		
		// Percore itens de uma lista ou array
		foreach ($pessoas as $idade => $nome) {
			echo "$nome tem $idade anos de idade.<br>";
		}
	}

	public function ler($file = 'teste.txt')
	{
		$nomes = file($file);
		foreach ($nomes as $nome) {
			echo "Bem vindo $nome.<br>";
		}
		
	}
	
}