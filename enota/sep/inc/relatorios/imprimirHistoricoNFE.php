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
	$codigo = $_POST['rdbTipo'];
?>

<!-- Início do css da visualização da página -->
	<style type="text/css" media="screen">
	<!--
	.style1 {font-family: Georgia, "Times New Roman", Times, serif}
	
	.tabela {
		font-family: Verdana, Arial, Helvetica, sans-serif;
		font-size: 12px;
		border-collapse:collapse;
		border: 1px solid #000000;
	}
	.tabelameio {
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
		/*margin: 10% 0%;*/
	}
	-->
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
							<p>RELAT&Oacute;RIO - HIST&Oacute;RICO NFE</p>
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
	$query =("SELECT * FROM notas");
	$sql_pesquisa = mysql_query ($query);
	$result = mysql_num_rows($sql_pesquisa);
	if($result){ //Se existir algum registro, mostra na tabela
?>

<!-- Início da Tabela -->
<table width="95%" class="tabela" border="1" cellspacing="0" style="page-break-after: always" align="center">
	<tr style="background-color:#999999">
		<?php
			if($result <= 1){
				echo "<center><b>Foi encontrado $result  Resultado</b></center>";
			}else{
				echo "<center><b>Foram encontrados $result  Resultados</b></center>";
			}
		?>
	</tr>
<?php
	if($codigo == 'codemissor'){
?>
	<tr style="background-color:#999999; font-weight:bold" align="center">
		<td>Prestador</td>
		<td align="center">
			<strong>CPF/CNPJ</strong>
		</td>
		<td align="center">
			<strong>Tomador</strong>
		</td>
		<td align="center">
			<strong>CPF/CNPJ</strong>
		</td>
		<td align="center">
			<strong>N&deg; Nota</strong>
		</td>
		<td align="center">
			<strong>Data Emiss&atilde;o</strong>
		</td>
		<td align="center">
			<strong>Base Calculo</strong>
		</td>
		<td align="center">
			<strong>Valor ISS</strong>
		</td>
		<td align="center">
			<strong>Total</strong>
		</td>
	</tr>
	<?php
	}else{
	?>
	<tr style="background-color:#999999; font-weight:bold" align="center">
		<td align="center">
			<strong>Tomador</strong>
		</td>
		<td align="center">
			<strong>CPF/CNPJ</strong>
		</td>
		<td align="center">
			<strong>Prestador</strong>
		</td>
		<td align="center">
			<strong>CPF/CNPJ</strong>
		</td>
		<td align="center">
			<strong>N&deg; Nota</strong>
		</td>
		<td align="center">
			<strong>Data Emiss&atilde;o</strong>
		</td>
		<td align="center">
			<strong>Base Calculo</strong>
		</td>
		<td align="center">
			<strong>Valor ISS</strong>
		</td>
		<td align="center">
			<strong>Total</strong>
		</td>
	</tr>
	<?php
	}// Fim do else
	
	if(mysql_num_rows($sql_pesquisa)){
		while ($dados = mysql_fetch_array($sql_pesquisa)){
			if($codigo == 'codemissor'){
				$codtipo = $dados['codemissor'];
			}else{
				$codtipo = $dados['codtomador'];
			}
			$query2 = ("SELECT * FROM notas WHERE $codigo = '$codtipo' GROUP BY $codigo");
	
			$sql_pesquisa2 = mysql_query ($query2);
			if(mysql_num_rows($sql_pesquisa2)){
				while ($dados2 = mysql_fetch_array($sql_pesquisa2)){
					$codemissor = $dados2['codemissor'];
					$nome = ("SELECT nome, cpf, cnpj FROM cadastro WHERE codigo = '$codemissor'");
					$pesquisanome = mysql_query($nome);
					//$resultnome = mysql_num_rows($pesquisanome);
					if(mysql_num_rows($pesquisanome)){
						while ($dadosnome = mysql_fetch_array($pesquisanome)){
							if($dadosnome['cpf'] == ''){
								$cpfcnpj = $dadosnome['cnpj'];
							}else{
								$cpfcnpj = $dadosnome['cpf'];
							}
							
							$explode = explode(" ",$dados2['datahoraemissao']);
							$separa = explode("-",$explode[0]);
							if($codigo == 'codemissor'){
		?>
				<tr>
                	<td bgcolor="white"  align="left">
						<font size="1"><?php echo $dadosnome['nome']; ?></font>
					</td>
                    <td bgcolor="white" align="center">
						<font size="1"><?php echo $cpfcnpj ?></font>
					</td>
                    <td bgcolor="white"  align="left">
						<font size="1"><?php echo $dados2['tomador_nome']; ?></font>
					</td>
					<td bgcolor="white"  align="center">
						<font size="1"><?php echo $dados2['tomador_cnpjcpf']; ?></font>
					</td>
                    <td bgcolor="white"  align="center">
						<font size="1"><?php echo $dados2['numero']; ?></font>
					</td>
                    <td bgcolor="white"  align="center">
						<font size="1"><?php echo $separa[2]."/".$separa[1]."/".$separa[0]; ?></font>
					</td>
					<td bgcolor="white" align="center">
						<font size="1"><?php echo "R$ ".DecToMoeda($dados2['basecalculo']); ?></font>
					</td>
                    <td bgcolor="white" align="center">
						<font size="1"><?php echo "R$ ".DecToMoeda($dados2['valoriss']); ?></font>
					</td>
					<td bgcolor="white" align="center">
						<font size="1"><?php echo "R$ ".DecToMoeda($dados['valortotal']); ?></font>
					</td>
				</tr>
        	<?php
							}else{//fim if($codigo == 'codemissor')
			?>
				<tr>
                	<td bgcolor="white"  align="left">
						<font size="1"><?php echo $dados2['tomador_nome']; ?></font>
					</td>
                    <td bgcolor="white" align="center">
						<font size="1"><?php echo $dados2['tomador_cnpjcpf']; ?></font>
					</td>
                    <td bgcolor="white"  align="left">
						<font size="1"><?php echo $dadosnome['nome']; ?></font>
					</td>
					<td bgcolor="white"  align="center">
						<font size="1"><?php echo $cpfcnpj; ?></font>
					</td>
                    <td bgcolor="white"  align="center">
						<font size="1"><?php echo $dados2['numero']; ?></font>
					</td>
                    <td bgcolor="white"  align="center">
						<font size="1"><?php echo $separa[2]."/".$separa[1]."/".$separa[0]; ?></font>
					</td>
					<td bgcolor="white" align="center">
						<font size="1"><?php echo "R$ ".DecToMoeda($dados2['basecalculo']); ?></font>
					</td>
                    <td bgcolor="white" align="center">
						<font size="1"><?php echo "R$ ".DecToMoeda($dados2['valoriss']); ?></font>
					</td>
					<td bgcolor="white" align="center">
						<font size="1"><?php echo "R$ ".DecToMoeda($dados['valortotal']); ?></font>
					</td>
				</tr>
        	<?php
							}//fim else
						}// Fim while ($dadosnome = mysql_fetch_array($pesquisanome))
					}//fim if $pesquisanome
				}//fim while ($dados2 = mysql_fetch_array($sql_pesquisa2))
			}// Fin if(mysql_num_rows($sql_pesquisa2))
		}//fim while ($dados = mysql_fetch_array($sql_pesquisa))
	}
	
	/*else{ //if(mysql_num_rows($sql_pesquisa))
			//caso não encontre resultados, a mensagem 'Não há resultados!' será mostrada na tela
            	echo "<tr style=\"background-color:#999999\"><td colspan=\"3\"><center><b><font class=\"fonte\">N&atilde;o h&aacute; resultados!</font></center></td></b></tr>";
	}*/
	
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