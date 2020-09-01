<?
header("Content-type: text/html; charset=utf-8");

// Código passado como parâmetro POST para a Página
$codigo = isset($_POST["codigo"]) ? $_POST["codigo"] : "";


/*********************************************
*  Valida um caracter, retornando se é
*  um caracter e não é um caracter especial
**********************************************/
function verificaCaracter($caracter, $apenasLetras){
	for($i=65;$i<=90;$i++){
		if(strtoupper($caracter) == chr($i)){
			return true;
		}
	}
	
	if(!$apenasLetras){
		
		for($i=48;$i<=57;$i++){
			if($caracter == chr($i)){
				return true;
			}
		}
		
		if($caracter == "_"){
			return true;
		}
	}
	
	return false;
}

/*********************************************
*   Lista de Palavras Reservadas
**********************************************/
function reservadas(){
	return array(1  => "auto",
				2  => "break",
				3  => "case",
				 "char",
				 "const",
				 "continue",
				 "default",
				 "do",

				 "double",
				 "else",
				 "enum",
				 "extern",
				 "float",
				 "for",
				 "goto",
				 "if",
			
				 "int",
				 "long",
				 "register",
				 "return",
				 "short",
				 "signed",
				 "sizeof",
				 "static",
			
				 "struct",
				 "switch",
				 "typedef",
				 "union",
				 "unsigned",
				 "void",
				 "volatile",
				 "while",
				
				 "asm", 
				 "cdecl", 
				 "far", 
				 "fortran", 
				 "huge", 
				 "interrupt", 
				 "near", 
				 "pascal", 
				 "typeof");
}

/*********************************************
*   Lista de operadores
**********************************************/
function operadores(){
	return array("+" => "matemático de soma",
				"-" => "matemático de subtração",
				"*" => "matemático de multiplicação",
				"/" => "matemático de divisão",
				"=" => "de atribuição",
				"==" => "lógico de igualdade",
				"!=" => "lógico de diferença",
				"%" => "matemático de percentual",
				">" => "lógico, indicando maior",
				"<" => "lógico, indicando menor",
				"<=" => "lógico, indicando menor ou igual",
				">=" => "lógico, indicando maior igual",
				"&&" => "relacional, indicando \"e\"",
				"||" => "relacional, indicando \"ou\"");
}

/*********************************************
* Função que faz uma análise Lexica na palavra 
* CASE SENSITIVE
**********************************************/
function analiseLexica($codigo)
{

	$retorno = "<b>".$codigo."</b>";
	$reservadas = reservadas();
	$operadores = operadores();
	
	foreach($reservadas as $codigoReservada => $palavraReservada)
	{
		if($codigo == $palavraReservada)
		{
			return $retorno." é palavra reservada. <b>Cód.:</b> ".$codigoReservada;
		}
	}
	
//	Verifica se é numérico
	if(is_numeric($codigo))
	{
	
//      Verifica se é número inteiro
		$numero = intval($codigo);
		
		if(($numero == $codigo) && is_int($numero))
		{
			return $retorno." é um valor inteiro.";
		}

//      Verifica se é número real
		$numero = floatval($codigo);
		
		if(($numero == $codigo) && (is_float($numero) || is_real($numero)))
		{
			return $retorno." é um valor real.";
		}
	}

//  Verifica se é um operador
	foreach($operadores as $operador => $descricaoOperador)
	{
		if($codigo == $operador)
		{
			return $retorno." é um operador ".$descricaoOperador.".";
		}
	}

//  Verifica Literal booleano
	if($codigo == "true" || $codigo == "false")
	{
		return $retorno." é um literal booleano.";
	}
	
//  Verifica se é uma string
	if( strlen($codigo) > 1 &&
		(	
			(
				substr($codigo, 0, 1) == "'" && 
				substr($codigo, strlen($codigo) - 1, 1) == "'"
			)||(
				substr($codigo, 0, 1) == "\"" && 
				substr($codigo, strlen($codigo) - 1, 1) == "\""
			)
		)
	)
	{
		return $retorno." é uma string.";
	}
	
//	Verifica se é variável
//	Verifica se o tamanho é menor que 30 caracteres e se inicia com letra
	if(strlen($codigo) <= 30 &&
		verificaCaracter(substr($codigo, 0, 1), true))
	{
//		Verifica se o restante da palavra não contém caracteres especiais
		$valido = true;
		for($i=1; $i<=strlen($codigo); $i++)
		{
			if(!verificaCaracter(substr($codigo, $i, 1), false))
			{
				$valido = false;
			}
		}
		if($valido)
		{
			return $retorno." pode ser o nome de uma variável ou procedimento.";
		}
	}

//  	Se não for nenhum dos acima, então, erro de sintaxe
	return $retorno." causará erro de sintaxe.";
	
}

// Chama a função que faz a análise
echo analiseLexica($codigo);

?>