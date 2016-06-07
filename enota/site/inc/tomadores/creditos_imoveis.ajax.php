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
require_once("../../../include/conect.php");
require_once("../../../funcoes/util.php");
require_once("../../../../../middleware/pmfeliz/autoload.php");
$imoveis = new Postgre_Smabas01();
$imoveis->setNumCad($_GET["q"]);
$cod = $_GET['cod'];
$sql = mysql_query("SELECT credito FROM cadastro WHERE codigo = '$cod'");
list($credito)=mysql_fetch_array($sql);
$iptu = mysql_query("SELECT abatimento_iptu FROM configuracoes");
list($abatimento)=mysql_fetch_array($iptu);
if(!$imoveis->CarregaNumCad()){
	echo "Nenhum resultado encontrado";
}else{
$valordesconto = $imoveis->getVlrDesc() - $credito;
$valormaximo = $imoveis->getVlrDesc() * ($abatimento / 100);
if($credito>$valormaximo){
	$acumulado = $credito - $valormaximo;
	$credito = $valormaximo;
}else{
	$acumulado = 0.00;	
}
?>
<table width="500" cellspacing="1" cellpadding="1">
	<tr>
    	<td width="220" bgcolor="#999999"><strong>LOGRADOURO:</strong></td><td bgcolor="#FFFFFF">&nbsp;<?php echo $imoveis->getEndCor(); ?></td>
    </tr>
    <tr>
    	<td bgcolor="#999999"><strong>CIDADE:</strong></td><td bgcolor="#FFFFFF">&nbsp;<?php echo $imoveis->getCidCor(); ?></td>
    </tr>
    <tr>
    	<td bgcolor="#999999"><strong>UF:</strong></td><td bgcolor="#FFFFFF">&nbsp;<?php echo $imoveis->getEstCor(); ?>
    </tr>
    <tr>
    	<td bgcolor="#999999"><strong>BAIRRO:</strong></td><td bgcolor="#FFFFFF">&nbsp;<?php echo $imoveis->getBaiCor(); ?></td>
    </tr>
    <!--<tr>
    	<td bgcolor="#999999"><strong>VALOR IPTU:</strong></td><td bgcolor="#FFFFFF">&nbsp;R$&nbsp;<?php echo DecToMoeda($imoveis->getVlrDesc()); ?></td>
    </tr>
    <tr>
    	<td bgcolor="#999999"><strong>CR&Eacute;DITO:</strong></td><td bgcolor="#FFFFFF">&nbsp;R$&nbsp;<input onkeyup="MaskMoeda(this);atualizacreditos(<?php /*echo $valormaximo;*/ ?>,<?php /*echo $imoveis->getVlrDesc()*/; ?>);return NumbersOnly(event);" type="text" onkeydown="atualizacreditos(<?php /*echo $valormaximo;*/ ?>,<?php /*echo $imoveis->getVlrDesc();*/ ?>);return NumbersOnly(event);" name="txtCredito" id="txtCredito" value="<?php /*echo DecToMoeda($credito);*/ ?>" class="texto" size="20" /></td>
    </tr>
    <tr>
    	<td bgcolor="#999999"><strong>VALOR M&Aacute;XIMO DE ABATIMENTO:</strong></td><td bgcolor="#FFFFFF">&nbsp;R$&nbsp;<?php /*echo DecToMoeda($valormaximo);*/ ?></td>
    </tr>
    <tr>
    	<td bgcolor="#999999"><strong>CR&Eacute;DITO ACUMULADO:</strong></td><td bgcolor="#FFFFFF">&nbsp;R$&nbsp;<?php /*echo DecToMoeda($acumulado);*/ ?></td>
    </tr>
    <tr>
    	<td bgcolor="#999999"><strong>VALOR COM DESCONTO:</strong></td><td bgcolor="#FFFFFF">&nbsp;R$&nbsp;<input type="text" disabled="disabled" readonly="readonly" name="txtValorDesconto" id="txtValorDesconto" value="<?php /*echo DecToMoeda($valordesconto);*/ ?>" onkeyup="MaskMoeda(this);"  class="texto" size="20" /></td>
    </tr>-->
    <tr>
    	<td bgcolor="#999999"></td><td bgcolor="#FFFFFF" align="right"><input type="submit" name="btConfirma" id="btConfirma" value="Confirmar" class="botao"/></td>
    </tr>
    
</table>
<?php
}