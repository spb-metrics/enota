<?php
/*
COPYRIGHT 2008 - 2010 DO PORTAL PUBLICO INFORMATICA LTDA

Este arquivo e parte do programa E-ISS / SEP-ISS

O E-ISS / SEP-ISS e um software livre; voce pode redistribui-lo e/ou modifica-lo
dentro dos termos da Licenca Publica Geral GNU como publicada pela Fundacao do
Software Livre - FSF; na versao 2 da Licenca

Este sistema e distribuido na esperanca de ser util, mas SEM NENHUMA GARANTIA,
sem uma garantia implicita de ADEQUACAO a qualquer MERCADO ou APLICACAO EM PARTICULAR
Veja a Licenca Publica Geral GNU/GPL em portugues para maiores detalhes

Voce deve ter recebido uma copia da Licenca Publica Geral GNU, sob o titulo LICENCA.txt,
junto com este sistema, se nao, acesse o Portal do Software Publico Brasileiro no endereco
www.softwarepublico.gov.br, ou escreva para a Fundacao do Software Livre Inc., 51 Franklin St,
Fith Floor, Boston, MA 02110-1301, USA
*/
?>

<?php //Includes
	include("../../inc/conect.php");
	include("../../funcoes/util.php");
?>

<?php //Pega o brasão
	$sql_brasao = mysql_query("SELECT brasao_nfe FROM configuracoes");
	list($BRASAO) = mysql_fetch_array($sql_brasao);
?>

<?php
	$estado = $_POST['rdbContador'];
?>

<!-- Início do css da visualização da página -->
	<style type="text/css" media="screen">
	.style1 {
		font-family: Georgia, "Times New Roman", Times, serif;
	}
	
	.tabela {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 12px;
		border-collapse:collapse;
		border: 1px solid #000000;
	}
	.tabela tr td{
		border: 1px solid #000000;
	}
	.fonte{
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	div.pagina {
		writing-mode: tb-rl;
		height: 100%;
	}
	</style>
<!-- Fim do css da visualização da página -->


<!-- Início do css da Impressão da página -->
	<style type="text/css" media="print">
	#DivImprimir{
		display: none; /*Tira a div imprimir na hora da impressão*/
	}
	</style>
<!-- Fim do css da Impressão da página -->

<title>Imprimir Relat&oacute;rio</title>
<div class="pagina"> <!-- Início div página -->
	<div id="DivImprimir">
		<input type="button" onClick="print();" value="Imprimir" /><br />
		<i><b>Este relat&oacute;rio &eacute; melhor visualizado em formato de impress&atilde;o em paisagem.</b></i>
	</div>
	
	<!-- Início do topo com as informações -->
	<div id="DivTopo">
		<table width="95%" height="120" border="2" cellspacing="0" class="tabela" align="center">
			<tr>
				<td width="106">
					<center>
						<img src="../../img/brasoes/<?php print $BRASAO; ?>" width="96" height="105"/>
					</center>
				</td>
				<td width="584" height="33" colspan="2">
					<span class="style1">
						<center>
							<p>RELAT&Oacute;RIO - CONTADORES </p>
							<p>PREFEITURA MUNICIPAL DE <?php print strtoupper($CONF_CIDADE); ?> </p>
							<p><?php print strtoupper($CONF_SECRETARIA); ?> </p>
						</center>
					</span>
				</td>
			</tr>
		</table>
	</div>
	<!-- Fim do topo com as informações -->
	
	<br>
        
<?php
	$query =("SELECT * FROM cadastro WHERE estado = '$estado' AND codtipo = '10'");
		
	$sql_pesquisa = mysql_query ($query);
	$result = mysql_num_rows($sql_pesquisa); //Pega quantos resultados voltaram
	if(mysql_num_rows($sql_pesquisa)){ //Se existir algum registro, mostra na tabela
?>
<!-- Início da Tabela -->
<table width="95%" class="tabela" border="1" cellspacing="0" style="page-break-after: always" align="center">
	<tr style="background-color:#999999">
		<?php
			if($result <= 1)
				echo "<center><b>Foi encontrado $result  Resultado</b></center>";
			else if($result >= 10)
				echo "<center><b>Foram encontrados 10  Resultados</b></center>";
			else
				echo "<center><b>Foram encontrados $result  Resultados</b></center>";
		?>
	</tr>
	
	<tr style="background-color:#999999; font-weight:bold" align="center">
		<td>Nome</td>
		<td>CPF/CNPJ</td>
		<td>Logradouro</td>
        <td>N&uacute;mero</td>
		<td>Complemento</td>
        <td>Bairro</td>
        <td>Munic&iacute;pio</td>
        <td>UF</td>
        <td>Estado</td>
     </tr>
		<?php
			while ($dados = mysql_fetch_array($sql_pesquisa)){
				if($dados['cpf'] == ''){
					$cpfcnpj = $dados['cnpj'];
				}else{
					$cpfcnpj = $dados['cpf'];
				}
						
				if ($dados['estado'] == 'A'){
					$estadocont = "Ativo";
				}elseif($dados['estado'] == 'I'){
					$estadocont = "Inativo";
				}elseif($dados['estado'] == 'NL'){
					$estadocont = "Não Liberado";
				}else{
					$estadocont = " ";
				}
		?>
	<tr>
		<td bgcolor="white"  align="left"><font size="1"><?php echo $dados['nome']; ?></font></td>
		<td bgcolor="white" align="center"><font size="1"><?php echo $cpfcnpj;?></font></td>
        <td bgcolor="white"  align="center"><font size="1"><?php echo $dados['logradouro']; ?></font></td>
		<td bgcolor="white"  align="center"><font size="1"><?php echo $dados['numero']; ?></font></td>
        <td bgcolor="white"  align="center"><font size="1"><?php echo $dados['complemento']; ?></font></td>
        <td bgcolor="white"  align="center"><font size="1"><?php echo $dados['bairro']; ?></font></td>
        <td bgcolor="white"  align="center"><font size="1"><?php echo $dados['municipio']; ?></font></td>
        <td bgcolor="white"  align="center"><font size="1"><?php echo $dados['uf']; ?></font></td>
       	<td bgcolor="white"  align="center"><font size="1"><?php echo $estadocont; ?></font></td>
	</tr>
		<?php
			}// Fim while ($dados = mysql_fetch_array($sql_pesquisa))
		?>
</table>
<?php

}else{
?>
<table width="95%" class="tabela" border="1" cellspacing="0" style="page-break-after: always" align="center">
	<tr style="background-color:#999999;font-weight:bold;" align="center">
		<td>N&atilde;o h&aacute; resultados!</td>
	</tr>
</table>
<?php
}
?>
</div>