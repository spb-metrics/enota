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
require_once("../../conect.php");
require_once("../../../funcoes/util.php");
require_once("../../nocache.php");

$codigo=$_POST['hdCodDif'];//recebe o codigo do hidden da declaracao que foi clicada

$sql_info = mysql_query("
	SELECT 
		dif_des.data,
		DATE_FORMAT(dif_des.competencia,'%m/%Y') as competencia,
		dif_des.total,
		SUM(dif_des_contas.iss) as 'iss',
		dif_des.codverificacao,
		dif_des.estado,
		inst_financeiras.nome,
		inst_financeiras.razaosocial,
		inst_financeiras.cnpj,
		inst_financeiras.logradouro,
		inst_financeiras.numero,
		inst_financeiras.municipio,
		inst_financeiras.uf
	FROM 
		dif_des 
	INNER JOIN 
		cadastro as inst_financeiras ON dif_des.codinst_financeira = inst_financeiras.codigo
	INNER JOIN
		dif_des_contas ON dif_des.codigo = dif_des_contas.coddif_des
	WHERE 
		dif_des.codigo = '$codigo'
	GROUP BY
		dif_des_contas.coddif_des
	") or die(mysql_error());
	$info = mysql_fetch_array($sql_info) or die(mysql_error());
	$info['endereco'] = $info['logradouro'].', '.$info['numero'];
	
	$aux = explode(" ",$info['data']);
	$info['data'] = $aux[0];
	
	//Altera o estado para seu valor por extenso
	switch($info['estado']){
		case "B": $str_estado = "Boleto";      break;
		case "N": $str_estado = "Normal";      break;
		case "C": $str_estado = "Cancelada";   break;
		case "E": $str_estado = "Escriturada"; break;		
	}
?>
<link href="../../../css/padrao.css" rel="stylesheet" type="text/css" media="screen">
<link rel="stylesheet" type="text/css" href="imprimir_contas_declaracao.css" media="print" /> <!-- serve para quando for imprimir esconder o botao -->
<script src="../../../scripts/padrao.js" type="text/javascript"></script>
<script type="text/javascript">
top.resizeTo(800,600);
</script>
<title>Declaracao de Institui��o financeira</title>
<input name="btImprimir" id="btImprimir" type="button" class="botao" value="Imprimir" onClick="document.getElementById('btImprimir').style.display = 'none';print();">
<p style="font:Verdana, Arial, Helvetica, sans-serif; font-size:20px"><b>Contas da Declara&ccedil;&atilde;o de Institui��o financeira</b><br />
</p>
<input type="hidden" name="hdCodUser" value="<?php echo $codigo;?>">
<table width="100%" style="text-indent:25px;" border="0">
	<tr bgcolor="#FFFFFF">
        <td width="25%" align="left"><b>Nome: </b></td>			
        <td align="left" colspan="3"><?php echo $info['nome'];?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td align="left"><b>CNPJ</b></td>
        <td width="16%" align="center"><?php echo $info['cnpj'];?></td>
        <td width="9%" align="right"><b>Endereco</b></td>
    <td width="50%" align="left"><?php echo $info['endereco'];?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    	<td align="left"><b>Municipio</b></td>
        <td align="left"><?php echo $info['municipio'];?></td>
        <td align="right"><b>UF</b></td>
        <td align="left"><?php echo $info['uf'];?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    	<td align="left"><b>Data de gera��o</b></td>
        <td align="left"><?php echo DataPt($info['data']);?></td>
        <td align="right"><b>Compet�ncia</b></td>
        <td align="left"><?php echo $info['competencia'];?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    	<td align="left"><b>Cod. Verifica��o</b></td>
        <td align="left"><?php echo $info['codverificacao'];?></td>
        <td align="right"><b>ISS</b></td>
        <td align="left"><?php echo DecToMoeda($info['iss']);?></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    	<td align="left"><b>Total</b></td>
        <td align="left"><?php echo DecToMoeda($info['total']);?></td>
        <td align="right"><b>Estado:</b></td>
    	<td align="left"><?php echo $str_estado; ?></td>
  </tr>
</table>

<?php
$sql=mysql_query("
				SELECT 
					contaoficial, 
					contacontabil, 
					titulo, 
					item, 
					saldo_mesanterior, 
					debito, 
					credito, 
					saldo_mesatual, 
					receita, 
					aliquota, 
					iss
				FROM
					dif_des_contas
				WHERE
					coddif_des='$codigo'

				");
?>
<br />
<table bordercolor="#000000" border="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px;">
    <tr>
        <td align="left">Conta Oficial</td>
        <td align="left">Conta Contabil</td>
        <td align="left">Titulo</td>
        <td align="left">Item</td>
        <td align="left">Saldo Anterior</td>
        <td align="left">Debito</td>
        <td align="left">Cr�dito</td>
        <td align="left">Saldo Atual</td>
        <td align="left">Receita</td>
        <td align="left">Aliquota</td>
        <td align="left">ISS</td>
    </tr>
    <tr>
    	<td colspan="11"><hr color="#000000" size="2" /></td>
    </tr>
    <?php
		while(list($contaoficial,$contacontabil,$titulo,$item,$saldo_mesantarior,$debito,$credito,$saldo_mesatual,$receita,$aliquota,$iss) = mysql_fetch_array($sql)){
	?>
    <tr bgcolor="#FFFFFF">
        <td align="left"><?php echo $contaoficial;?></td>
        <td align="left"><?php echo $contacontabil;?></td>
        <td align="left"><?php echo $titulo;?></td>
        <td align="left"><?php echo $item;?></td>
        <td align="left"><?php echo DecToMoeda($saldo_mesantarior);?></td>
        <td align="left"><?php echo DecToMoeda($debito);?></td>
        <td align="left"><?php echo DecToMoeda($credito);?></td>
        <td align="left"><?php echo DecToMoeda($saldo_mesatual);?></td>
        <td align="left"><?php echo DecToMoeda($receita);?></td>
        <td align="left"><?php echo DecToMoeda($aliquota);?></td>
        <td align="left"><?php echo DecToMoeda($iss);?></td>
    </tr>
    <?php
		}//fim while
	?>
</table>
