<?php
/*
LICEN�A P�BLICA GERAL GNU
Vers�o 3, 29 de junho de 2007
    Copyright (C) <2010>  <PORTAL P�BLICO INFORM�TICA LTDA>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

Este programa � software livre: voc� pode redistribu�-lo e / ou modificar sob os termos da GNU General Public License como publicado pela Free Software Foundation, tanto a vers�o 3 da Licen�a, ou�(por sua op��o) qualquer vers�o posterior.

Este programa � distribu�do na esperan�a que possa ser �til, mas SEM QUALQUER GARANTIA, sem mesmo a garantia impl�cita de COMERCIALIZA��O ou ADEQUA��O A UM DETERMINADO PROP�SITO. Veja a GNU General Public License para mais detalhes.

Voc� deve ter recebido uma c�pia da GNU General Public License��junto com este programa. Se n�o, veja <http://www.gnu.org/licenses/>.


This is an unofficial translation of the GNU General Public License into Portuguese. It was not published by the Free Software Foundation, and does not legally state the distribution terms for software that uses the GNU GPL � only the original English text of the GNU GPL does that. However, we hope that this translation will help Portuguese speakers understand the GNU GPL better.

Esta � uma tradu��o n�o oficial em portugu�s da Licen�a P�blica Geral GNU (da sigla em ingl�s GNU GPL). Ela n�o � publicada pela Free Software Foundation e n�o declara legalmente os termos de distribui��o para softwares que a utilizam � somente o texto original da licen�a, escrita em ingl�s, faz isto. Entretanto, acreditamos que esta tradu��o ajudar� aos falantes do portugu�s a entend�-la melhor.


// Originado do Projeto ISS Digital � Portal P�blico que tiveram colabora��es de Vin�cius Kampff, 
// Rafael Romeu, Lucas dos Santos, Guilherme Flores, Maikon Farias, Jean Farias e Daniel Bohn
// Acesse o site do Projeto www.portalpublico.com.br             |
// Equipe Coordena��o Projeto ISS Digital: <informatica@portalpublico.com.br>   |

*/
?>



<fieldset style="width:800px"><legend>Resultado da Pesquisa</legend>
<?php
require_once("../conect.php");
require_once("../nocache.php");
require_once("../../funcoes/util.php");

//ve se alguma nota foi cancelada
if($_GET["txtCodigoCancela"]){ 
	$codigo_nota = base64_decode($_GET["txtCodigoCancela"]);
	$motivoCancel = $_GET['txtMotivoCancela'];
	mysql_query("UPDATE notas SET estado = 'C', motivo_cancelamento = '$motivoCancel' WHERE codigo = '$codigo_nota'"); 
	$sql_verifica_notaavulsa = mysql_query("SELECT codigo FROM guia_pagamento WHERE codnota = '$codigo_nota'");
	if(mysql_num_rows($sql_verifica_notaavulsa)){
		$guia = mysql_fetch_object($sql_verifica_notaavulsa);
		mysql_query("UPDATE guia_pagamento SET estado = 'C', motivo_cancelamento = '$motivoCancel' WHERE codigo = '{$guia->codigo}'");
	}
}//fim if se cancela uma nota.

$numero            = $_GET['txtNumeroNota'];
$nome              = $_GET['txtNomeEmissor'];
$codverificacao    = $_GET['txtCodigoVerificacao'];
$prestador_cnpjcpf = $_GET['txtCNPJPrestador'];
$tomador_cnpjcpf   = $_GET['txtCNPJ'];
$data_inicial      = DataMysql($_GET['txtDataInicial']);
$data_final		   = DataMysql($_GET['txtDataFinal']);
$tipo              = $_GET['rdTipo'];

$string = "";
if($numero){
	$string .= " AND notas.numero = '$numero'";
}

if($prestador_cnpjcpf){
    if(strlen($prestador_cnpjcpf) == 18){
        $string .= " AND cadastro.cnpj = '$prestador_cnpjcpf'";
    }elseif(strlen($prestador_cnpjcpf) == 14){
        $string .= " AND cadastro.cpf = '$prestador_cnpjcpf'";
    }
}

if($nome){
	$string .= " AND cadastro.nome LIKE '%$nome%'";
}

if($tomador_cnpjcpf){
	$string .= " AND notas.tomador_cnpjcpf = '$tomador_cnpjcpf'";
}

if($data_inicial){
	$string .= " AND DATE(notas.datahoraemissao) >= '$data_inicial'";
}

if($data_final){
	$string .= " AND DATE(notas.datahoraemissao) <= '$data_final'";
}

if($tipo != "T"){
	if($tipo == "A"){
		$string = " AND guia_pagamento.codnota <> ''";
	}else{
		$string = " AND guia_pagamento.codnota IS NULL";
	}
}

$query= ("
	SELECT
		notas.codigo, 
		notas.numero, 
		notas.codverificacao,
		notas.datahoraemissao, 
		notas.codemissor, 
		notas.tomador_nome,
		notas.tomador_cnpjcpf, 
		notas.estado,  
		cadastro.nome,
		cadastro.cnpj,
		guia_pagamento.codnota
	FROM
		notas
	INNER JOIN 
		cadastro ON notas.codemissor = cadastro.codigo	
	LEFT JOIN
		guia_pagamento ON guia_pagamento.codnota = notas.codigo
	WHERE
		notas.codverificacao LIKE '$codverificacao%' $string
	ORDER BY 
		notas.codigo DESC
"); // fim sql


$sql=Paginacao($query,'frmNfe','divResultado');
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
	<?php 
	if(mysql_num_rows($sql)>0){ ?>
	  <tr>
		<td width="45" align="center">N&ordm;</td>
		<td width="80" align="center">C�d Verif</td>
		<td width="70" align="center">D/H Emiss�o</td>
		<td width="200" align="center">Nome Prestador</td>
		<td width="200" align="center">Nome Tomador</td>
        <td align="center">Avulsa</td>
		<td width="70" align="center">Estado</td>
		<td width="75">&nbsp;</td>
	  </tr>
	  <tr>
		<td colspan="8" height="1" bgcolor="#999999"></td>
	  </tr>
	<?php
	while(list($codigo, $numero, $codverificacao, $datahoraemissao, $codempresa, $tomador_nome, $tomador_cnpjcpf, $estado, $emissor_nome,$emissor_cnpj,$gp_cod_nota) = mysql_fetch_array($sql)) {
		if($gp_cod_nota){
			$nota_avulsa = "Sim";
		}else{
			$nota_avulsa = "N�o";
		}
		// mascara o codigo com cripto base64 
		$crypto = base64_encode($codigo);
		if($estado == "C"){$cor = "#FFAC84";}else{$cor = "#FFFFFF";}
	 
	
	?>    
	  <tr bgcolor="<?php echo $cor;?>">
		<td width="45" align="right"><?php echo $numero; ?></td>
		<td width="80" align="center" ><?php echo $codverificacao;  ?></td>	
		<td width="70" align="center"><?php echo substr($datahoraemissao,8,2)."/".substr($datahoraemissao,5,2)."/".substr($datahoraemissao,0,4)." ".substr($datahoraemissao,11,5); ?></td>
		<td width="200" align="left" ><?php echo $emissor_nome; ?></td>
		<td width="200" align="left"><?php echo $tomador_nome; ?></td>
        <td align="center"><?php echo $nota_avulsa;?></td>
		<td width="75" align="center">
			<?php 
				switch ($estado) { 
					case "C": echo "Cancelado"; break;
					case "N": echo "Normal"; break;
					case "B": echo "Boleto Gerado"; break;
					case "E": echo "Escriturada"; break;
				} 
			?>
		</td>	
		<td bgcolor="#FFFFFF" width="60"><img  style="cursor:pointer;" title="Imprimir Nota" src="img/botoes/botao_imprimir.jpg" onclick="document.getElementById('CODIGO').value='<?php echo $crypto;?>';cancelaAction('frmNfe','inc/nfe/imprimir.php','_blank')" />
		<?php
		if ($estado !== "C") {
		?>
		
		<img style="cursor:pointer;" title="Cancelar Nota" src="img/botoes/botao_cancelar.jpg" 
		onclick="CancelaNota('<?php echo $crypto;?>','Cancelar nota N� <?php echo "$numero de $emissor_nome"; ?>?');" />
		<?php
		} // fecha if
		?>
		</td>
	  </tr>
	  <?php
		} // fim while  
	}else{//fim if se tem resultados
	?>
	<tr>
		<td><strong><center>Nenhum resultado encontrado.</center></strong></td>
	</tr>
	<?php
	}//else se nao tem resultados da busca
  ?> 
</table>
<input type="hidden" name="CODIGO" id="CODIGO" />
<input type="hidden" name="txtCodigoCancela" id="txtCodigoCancela" />
<input type="hidden" name="txtMotivoCancela" id="txtMotivoCancela" />	
</fieldset>
