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
$CODIGO = $_REQUEST['txtCodigo']; ?>
<?php 

 $sql = mysql_query("UPDATE notas SET estado='C', motivo_cancelamento='$txtMotivoCancelar' WHERE codigo='$txtCodigo'"); 
 
 $sql=mysql_query("
 SELECT 
 cadastro.codigo,
 notas.tomador_email,
 notas.numero,notas.rps_numero,
 cadastro.nome,
 cadastro.cnpj,
 cadastro.cpf,
 DATE_FORMAT(notas.datahoraemissao,'%d/%m/%Y %h:%i:%s'),
 notas.codverificacao,
 cadastro.email 
 FROM notas 
 INNER JOIN cadastro ON notas.codemissor = cadastro.codigo 
 WHERE notas.codigo = '$CODIGO'");
 
 list($codigo_emp,$email,$num_nota,$num_rps,$nome_empresa,$em_cnpj,$em_cpf,$dataehora,$codverificacao,$empresa_email)=mysql_fetch_array($sql);
 $cpfcnpf_empresa = $em_cnpj ? $em_cnpj : $em_cpf;

    $msg = "Comunicamos que a NFE com os seguintes dados foi cancelada pela empresa prestadora de servi�o:<br><br>
	- N�mero da nota: $num_nota;<br>
	- Com data e hora de emiss�o de: $dataehora ;<br>
	- C�digo de verifica��o: $codverificacao ;<br>
	- RPS N�mero: $num_rps <br>	
	- Prestador de servi�o: $nome_empresa ;<br>
	- CPF/CNPJ do prestador de servi�o: $cpfcnpf_empresa ;<br>  ";
	
	
	
	$assunto = "$nome_empresa (NF-e $PREFEITURA).";

	

	$headers  = "MIME-Version: 1.0\r\n";

	$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

	$headers .= "From: $nome_empresa <$empresa_email> \r\n";

	$headers .= "Cc: \r\n";

	$headers .= "Bcc: \r\n";

	
	mail("$email",$assunto,$msg,$headers);
 

 add_logs('Cancelou nota');
 print("<script language=JavaScript>alert('Nota cancelada com sucesso!')</script>"); 
 
?>