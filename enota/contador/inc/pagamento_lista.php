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
	/* if($_POST['btCancelarGuia'] != ""){
		$sql = mysql_query("
			SELECT 
			guias_declaracoes.codrelacionamento,
			guias_declaracoes.codguia
			FROM 
			guias_declaracoes 
			INNER JOIN 
			guia_pagamento ON guia_pagamento.codigo = guias_declaracoes.codguia
			WHERE 
			guia_pagamento.chavecontroledoc = '".$_POST['txtCodGuia']."'
		");
		list($COD_NOTA,$COD_GUIA) = mysql_fetch_array($sql);
		//usa o codigo encontrado com a pesquisa sql e efetua a a tualizacao
		mysql_query("UPDATE notas SET estado = 'N' WHERE codigo = '$COD_NOTA'");
		//deleta a guia de pagamento	
		mysql_query("DELETE FROM guia_pagamento WHERE codigo = '$COD_GUIA'");
		mysql_query("DELETE FROM guias_declaracoes WHERE codguia = '$COD_GUIA'");
		echo "<script>alert('Guia Cancelada');</script>";
		add_logs('Cancelou uma guia');
	} */ 
  $cod = $_POST['cmbEmpresaCliente'];
  $sql=mysql_query("
  	SELECT 
		guia_pagamento.codigo,
		guia_pagamento.datavencimento,
		guia_pagamento.valor,
		guia_pagamento.chavecontroledoc,
		guia_pagamento.pago,
		guia_pagamento.nossonumero
	FROM 
		guia_pagamento
	INNER JOIN
		livro ON livro.codigo = guia_pagamento.codlivro 
	WHERE 
		livro.codcadastro = '$cod' AND livro.estado = 'B'
	ORDER BY 
		guia_pagamento.pago ASC
	
	");
 ?>
 
<form method="post" onsubmit="return ConfirmaForm();">
<input type="hidden" name="btOp" value="Guias Emitidas" />
<input type="hidden" name="txtCodGuia" id="txtCodGuia" />
<table border="0" align="center" cellpadding="0" cellspacing="1">
    <tr>
      <td width="10" height="10" bgcolor="#FFFFFF"></td>
	  <td width="150" align="center" bgcolor="#FFFFFF" rowspan="3">Guias Emitidas</td>
      <td width="420" bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
	  <td height="1" bgcolor="#CCCCCC"></td>
      <td bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
	  <td height="10" bgcolor="#FFFFFF"></td>
      <td bgcolor="#FFFFFF"></td>
	</tr>
	<tr>
		<td colspan="3" height="1" bgcolor="#CCCCCC"></td>
	</tr>
	<tr>
		<td height="60" colspan="3" bgcolor="#CCCCCC">

<table border="0" width="100%" cellpadding="2" cellspacing="2">
<?php
if(mysql_num_rows($sql)>0){
?>
 <tr bgcolor="#999999">
   <td width="217" align="center">
      <b>Vencimento</b>   </td>
   <td width="85" align="center">
      <b>Valor</b>   </td>
   <td width="109" align="center">
      <b>Nosso n�mero</b>   </td>
   <td width="84">   </td>  
 </tr>
 <?php
 while(list($codigo,$data,$valor,$chavecontroledoc,$pago,$nossonumero)=mysql_fetch_array($sql))
 {
 ?>
 <tr <?php if($pago == "S"){ echo "bgcolor=\"#FFAC84\"";}else{ echo "bgcolor=\"#FFFFFF\"";}?>>
   <td align="center">
      <?php
	   $data = implode('/',array_reverse(explode("-",$data)));
	   echo $data; ?>
   </td>
   <td align="center">
     <?php echo DecToMoeda($valor); ?>
   </td>
   <td align="center">
     <?php echo $nossonumero; ?>
   </td>  
   <td align="center" bgcolor="#FFFFFF">
   		<input name="btImprimir" type="button" id="btImp" value=" " onclick="window.open('inc/segundavia.php?hdCodGuia=<?php echo $codigo;?>')" />
   </td>
 </tr>
 <?php 
 }//fim while
}else{
?>
	<tr>
		<td align="center" colspan="4">N�o h� guias emitidas</td>
	</tr>
<?php
}
 ?>
</table>
	  </td>
	</tr>
	<tr>
    	<td height="1" colspan="3" bgcolor="#CCCCCC"></td>
	</tr>
</table>
</form>