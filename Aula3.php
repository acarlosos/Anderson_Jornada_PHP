<?php

$aula3 = new Aula3();
$aula3->aprovado(7);
$aula3->aprovadoOuReprovado(4);
$aula3->aprovadoOuReprovadoOuRecuperacao(7);
$aula3->aprovadoOuReprovadoOuRecuperacaoAninhado(5.01);
echo $aula3->mes(4);
/**
 * Aula 3
 * Estrutua de decisão
 */
class Aula3
{
	
	public function aprovado($media)
	{
		if($media >= 6 ) {
			echo "Aluno Aprovado.<br>";
		}
	}

	public function aprovadoOuReprovado($media)
	{
		if($media >= 6 ) {
			echo "Aluno Aprovado.<br>";
		}else{
			echo "Aluno Reprovado.<br>";
		}
	}

	public function aprovadoOuReprovadoOuRecuperacao($media)
	{
		if($media >= 6 ) {
			echo "Aluno Aprovado.<br>";
		}else if($media >= 5.0 && $media <= 5.9 ){
			echo "Aluno em Recuperação.<br>";
		}else{
			echo "Aluno Reprovado.<br>";
		}
	}

	public function aprovadoOuReprovadoOuRecuperacaoAninhado($media) {

		if($media <= 10 && $media >= 0 ){

			if($media < 6 ){

				if($media < 5 ) {
					echo "Aluno Reprovado.<br>";
				}

				if($media >= 5.0 && $media <= 5.9 ) {
					echo "Aluno em Recuperação.<br>";
				}

			}else{
				echo "Aluno Aprovado.<br>";
			}

		}else{
			echo 'Media inválida.<br>';
		}

	}

	public function mes($mes)
	{
		switch ($mes) {
			case '1':
				return 'Janeiro';
				break;
			case '2':
				return 'Fevereiro';
				break;
			case '3':
				return 'Março';
				break;
			case '4':
				return 'Abril';
				break;
			case '5':
				return 'Maio';
				break;
			case '6':
				return 'Junho';
				break;
			case '7':
				return 'Julho';
				break;
			case '8':
				return 'Agosto';
				break;
			case '9':
				return 'Setembro';
				break;
			case '10':
				return 'Outubro';
				break;
			case '11':
				return 'Novembro';
				break;
			case '12':
				return 'Dezembro';
				break;
			
			default:
				return 'Não há mês';
				break;
		}
	}
}