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
$tipopessoa=$_POST['cmbInsTipoPessoa'];
$basecalc=$_POST['txtInsBaseCalculo'];
$incidencia=$_POST['cmbInsIncidencia'];
$venc=DataMysql($_POST['txtInsDiaVencimento']);
$docfiscal=$_POST['cmbInsDocFiscal'];
$codcategoria = $_POST['cmbCategoria'];
$codservico = $_POST['txtInsCodServico'];
$descricao = nl2br($_POST['txtInsDescServicos']);
$aliquota = $_POST['txtInsAliquota'];
$aliquotair = $_POST['txtInsAliquotaIR'];

if(($descricao !="") &&($aliquota !="") &&($aliquotair !="")){
  if(is_numeric($aliquota) || is_numeric($aliquotair)){
	  $sql_codservico = mysql_query("SELECT codigo FROM servicos WHERE codservico = '$codservico'");
	  $sql_descricao = mysql_query("SELECT codigo FROM servicos WHERE descricao = '$descricao'");
	  
	  if(mysql_num_rows($sql_codservico) > 0){
	  	print("<script language=JavaScript> alert('J� existe um servico com este c�digo de servi�o');</script>"); 
	  }elseif(mysql_num_rows($sql_descricao) > 0){
		print("<script language=JavaScript> alert('J� existe um servico com esta descri��o');</script>"); 	  
	  }else{
		  $sql=mysql_query("
			  INSERT INTO servicos
				  SET codservico='$codservico',
				  descricao= '$descricao',
				  aliquota= '$aliquota',
				  aliquotair= '$aliquotair',
				  estado='A',
				  codcategoria='$codcategoria',
				  tipopessoa='$tipopessoa',
				  basecalculo='$basecalc',
				  incidencia='$incidencia',
				  datavenc='$venc',
				  docfiscal='$docfiscal'
		  ");
		  print("<script language=JavaScript> alert('Servi�o inserido com sucesso');</script>");   
		  add_logs('Inseriu novo servi�o');	
	 }	  
  }
  else
  {
   print("<script language=JavaScript> alert('Ambas aliquotas devem ser preenchidas com n�meros e ponto, verifique exemplo');</script>");
  }
}
else
{
  print("<script language=JavaScript> alert('Favor preencher campos obrigat�rios');</script>");
}



?>

