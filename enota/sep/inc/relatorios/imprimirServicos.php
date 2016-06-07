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

<?php //Pega o bras�o e o estado
	$sql_brasao = mysql_query("SELECT brasao_nfe FROM configuracoes");
	list($BRASAO) = mysql_fetch_array($sql_brasao);
	
	$sql_estado = mysql_query("SELECT estado FROM configuracoes");
	list($ESTADO) = mysql_fetch_array($sql_estado);
?>

<?php //Define o t�tulo do relat�rio de acordo com o que vem do rdbServicos
	if ($_POST['rdbServicos'] == 'lista')
		$titulo = 'LISTA DE SERVI�OS';
	
	else if ($_POST['rdbServicos'] == 'vinculadas')
		$titulo = 'EMPRESAS VINCULADAS POR ATIVIDADE';
	
	else if ($_POST['rdbServicos'] == 'media')
		$titulo = 'COMPARATIVO POR M�DIA DE TODAS AS ATIVIDADES';
	
	else if ($_POST['rdbServicos'] == 'municipio')
		$titulo = 'ATIVIDADES ADQUIRIDAS DE EMPRESAS DE FORA DO MUNIC�PIO';
	
	else if($_POST['rdbServicos'] == 'resumo')
		$titulo = 'RESUMO DAS ATIVIDADES EFETUADAS';
		
	else if($_POST['rdbServicos'] == 'area')
		$titulo = 'LISTA DE SERVI�OS POR CATEGORIA E SERVI�O';
		
	else if($_POST['rdbServicos'] == 'categ')
		$titulo = 'LISTA ESTAT�STICA DE SERVI�OS POR CATEGORIA';
		
		
	 //Pega o m�s que veio por post
	$mes = $_POST['cmbMes'];
?>

<!-- In�cio do css da visualiza��o da p�gina -->
	<style type="text/css" media="screen">
	.style1 {
		font-family: Georgia, "Times New Roman", Times, serif;
		font-size:15px;
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
<!-- Fim do css da visualiza��o da p�gina -->


<!-- In�cio do css da Impress�o da p�gina -->
	<style type="text/css" media="print">
	#DivImprimir{
		display: none; /*Tira a div imprimir na hora da impress�o*/
	}
	</style>
<!-- Fim do css da Impress�o da p�gina -->


<title>Relat&oacute;rio de Servi&ccedil;os</title>

<div class="pagina"> <!-- In�cio div p�gina -->
	<div id="DivImprimir">
		<input type="button" onClick="print();" value="Imprimir" /><br />
	</div>
	
	<!-- In�cio do topo com as informa��es -->
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
							<p>RELAT&Oacute;RIO - <b><?php print strtoupper($titulo); ?></b> </p>
							<p>PREFEITURA MUNICIPAL DE <?php print strtoupper($CONF_CIDADE); ?> </p>
							<p><?php print strtoupper($CONF_SECRETARIA); ?> </p>
						</center>
					</span>
				</td>
			</tr>
		</table>
	</div>
	<!-- Fim do topo com as informa��es -->
	
	<br>

<?php //Verifica a op��o marcada e chama o arquivo que vai gerar o relar�rio
	if ($_POST['rdbServicos'] == 'lista')
		include("imprimirServicosLista.php");
		
	else if ($_POST['rdbServicos'] == 'vinculadas')
		include("imprimirServicosVinculadas.php");
		
	else if ($_POST['rdbServicos'] == 'media')
		include("imprimirServicosMedia.php");
		
	else if ($_POST['rdbServicos'] == 'municipio')
		include("imprimirServicosMunicipio.php");
		
	else if ($_POST['rdbServicos'] == 'resumo')
		include("imprimirServicosResumo.php");
		
	else if ($_POST['rdbServicos'] == 'area')
		include("imprimirServicosArea.php");
		
	else if ($_POST['rdbServicos'] == 'categ')
		include("imprimirServicosCateg.php");
?>
</div> <!-- Fim div p�gina -->