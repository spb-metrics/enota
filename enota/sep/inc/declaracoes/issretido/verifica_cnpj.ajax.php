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
<?php
	include("../../conect.php");
	include("../../../funcoes/util.php");
	/*$cnpj = $_SESSION['login'];
	$sqlcnpj = mysql_query("SELECT codigo, nome, razaosocial, cnpj, logradouro, municipio, uf, email FROM cadastro WHERE cnpj = '$cnpj' AND estado = 'A'");
	list($codigo,$nome,$razaosocial,$cnpj_cartorio,$endereco,$municipio,$uf,$email)=mysql_fetch_array($sqlcnpj);*/
	
	
?>
<fieldset>
<form method="post" name="frmDesSemTomador" onsubmit="document.getElementById('hdTotalInputs').value=totalemissores_des;">	
	<input type="hidden" name="hdTotalInputs" id="hdTotalInputs" />
	<input type="hidden" name="include" id="include" value="<?php echo $_GET['include'];?>" />
	<table width="100%" height="100%" bgcolor="#CCCCCC" border="0" align="center" cellpadding="5" cellspacing="0">
		<tr>
			<td width="15%" align="left" valign="middle">CNPJ:</td>
			<td width="10%" align="left" valign="middle">
				<input type="text" name="txtCNPJ" id="txtCNPJ" 
				onkeyup="MaskCNPJ(this);" maxlength="18" size="20" class="texto" />
			</td>
		</tr>
		<tr>
			<td colspan="3">OU</td>
		</tr>
		<tr>
			<td>Inscr. Municipal: </td>
			<td><input name="txtIM" type="text" id="txtIM" class="texto" size="20" /></td>
			<td align="left">
				<input name="btOk" type="button" value="Verificar" class="botao" onclick="verificaDesissretido('txtCNPJ','txtIM','divInfos')" />
			</td>
		</tr>
		<tr>
			<td colspan="3" align="left"><input type="submit" name="btVoltar" id="btVoltar" class="botao" value="Voltar" /></td>
		</tr>
	</table>
	<div id="divInfos" style="width:100%;"></div>
</form>
</fieldset>