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
//arquivo com as configuracoes de HOST, USUARIO, SENHA e BANCO
require_once dirname(__FILE__).'/config.php';

// Conectar ao banco de dados das prefeituras
$conectar_pref = mysql_connect($HOST,$USUARIO, $SENHA); 
if (!$conectar_pref) { die('N&atilde;o foi poss&iacute;vel  conectar: ' . mysql_error()); } 

// Seleciona o banco de dados
$db_selected_pref = mysql_select_db($BANCO, $conectar_pref);
if (!$db_selected_pref) {die ('N&atilde;o foi poss&iacute;vel  acessar a base: ' . mysql_error());}
//mysql_close($conectar);

//SELEIONA O CODIGO DA EMPRESA

 if($_SESSION['login'] != "")
 {
  $NOME =$_SESSION['nome'];
  $CODIGO = $_SESSION['codempresa'];
  $sql_codigo_empresa=mysql_query("SELECT codigo, ultimanota, senha FROM cadastro WHERE nome = '$NOME' AND codigo = '$CODIGO'");
  list($CODIGO_DA_EMPRESA,$ULTIMA_NOTA,$SENHA_EMPRESA)=mysql_fetch_array($sql_codigo_empresa);
 }

// lista confguracoes
$sql_configuracoes = mysql_query("
	SELECT 
		endereco, 
		cidade, 
		estado, 
		cnpj, 
		email, 
		secretaria, 
		lei, 
		decreto, 
		topo_nfe, 
		logo_nfe,
		brasao_nfe, 
		codlayout, 
		declaracoes_atrazadas, 
		gerar_guia_site ,
		codintegracao
	FROM  
		configuracoes
");
list($CONF_ENDERECO, $CONF_CIDADE, $CONF_ESTADO, $CONF_CNPJ, $CONF_EMAIL, $CONF_SECRETARIA, $CONF_LEI, $CONF_DECRETO, $CONF_TOPO, $CONF_LOGO,$CONF_BRASAO, $CONF_CODLAYOUT, $DEC_ATRAZADAS,$GERAR_GUIA_SITE,$CODINTEGRACAO) = mysql_fetch_array($sql_configuracoes);

if($CODINTEGRACAO!=0){
  	$sql_integracao=mysql_query("SELECT empresa,diretorio FROM integracao WHERE codigo=$CODINTEGRACAO");
	list($EMPRESAINTEGRACAO,$DIRETORIOINTEGRACAO)=mysql_fetch_array($sql_integracao);
}
	


$sql_boleto_banco = mysql_query("
	SELECT bancos.boleto
	FROM boleto
	INNER JOIN bancos ON bancos.codigo = boleto.codbanco
");
list($BOLETO_BANCO)=mysql_fetch_array($sql_boleto_banco);
?>
