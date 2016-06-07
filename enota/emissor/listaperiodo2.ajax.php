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
session_name('emissor');
session_start();

include("inc/conect.php");
include("../funcoes/util.php");

if(isset($_SESSION['codempresa'])){
	$codigo=$_SESSION["codempresa"];
}else{
	$codigo=$_GET['codempresa'];
}

$anoselecionado=$_GET['cmbAno'];

if($_GET[hdAcesso] == "Declaracao"){
    $mesFechado = mesFechado($anoselecionado,$codigo);
}

$pg=base64_decode($_GET['pg']);

switch($pg){
	case 'des': $nometabela='des'; $codtipo='codcadastro'; break;
	case 'decc': $nometabela='decc_des'; $codtipo='codempreiteira'; break;
	case 'dec': $nometabela='cartorios_des'; $codtipo='codcartorio'; break;
	case 'dif': $nometabela='dif_des'; $codtipo='codinst_financeira'; break;
	case 'doc': $nometabela='doc_des'; $codtipo='codopr_credito'; break;
	case 'dop': $nometabela='dop_des'; $codtipo='codorgaopublico'; break;
	case 'mei': $nometabela='mei_des'; $codtipo='codemissor'; break;
	case 'simples': $nometabela='simples_des'; $codtipo='codemissor'; break;
	default: $pg="nulo";
}

$sql_emissor = mysql_query("SELECT * FROM cadastro WHERE codigo='$codigo'");
$dados=mysql_fetch_array($sql_emissor);

$anoatual=date("Y");
$diaatual=date("Y-m-d");

if($dados['datainicio']==NULL || $dados['datainicio']==0000-00-00){
	$dados['datainicio'] = $diaatual;
}

if($dados['datafim']!=NULL){
	if($dados['datafim']<$dados['datainicio']){ $dados['datafim']=NULL; }
	if($dados['datafim']>$diaatual){ $dados['datafim']=NULL; }
}

$anoinicioempresa=(int)substr($dados['datainicio'],0,-6);
$mesempresa=(int)substr($dados['datainicio'],6,2);
$mesfimempresa=(int)substr($dados['datafim'],6,2);
$anofimempresa=(int)substr($dados['datafim'],0,-6);
$mes=date("n");

$meses=array("1"=>"Janeiro","Fevereiro","Mar&ccedil;o","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
if($anoselecionado!=""){
echo "<select id=\"cmbMes\" name=\"cmbMes\">";
if($pg=="nulo"){
	if($dados['datafim']==NULL){
		if($anoselecionado==$anoinicioempresa && $anoselecionado==$anoatual){
			for($ind=$mesempresa;$ind<=$mes;$ind++){
                if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}elseif($anoselecionado==$anoinicioempresa && $anoselecionado!=$anoatual){
			for($ind=$mesempresa;$ind<=12;$ind++){
				if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}elseif($anoselecionado!=$anoinicioempresa && $anoselecionado==$anoatual){
			for($ind=1;$ind<=$mes;$ind++){
				if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}else{
			for($ind=1;$ind<=12;$ind++){
				if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}
	}else{
		if($anoselecionado==$anoinicioempresa && $anoselecionado==$anofimempresa){
			for($ind=$mesempresa;$ind<=$mesfimempresa;$ind++){
				if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}elseif($anoselecionado==$anofimempresa && $anoselecionado!=$anoinicioempresa){
			for($ind=1;$ind<=$mesfimempresa;$ind++){
				if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}elseif($anoselecionado!=$anofimempresa && $anoselecionado==$anoinicioempresa){
			for($ind=$mesempresa;$ind<=12;$ind++){
				if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}else{
			for($ind=1;$ind<=12;$ind++){
				if(!in_array($ind,$mesFechado)){
                    echo "<option value='$ind'>{$meses[$ind]}</option>";
                }
			}
		}
	}
}else{
	if(isset($_GET['stringsql'])){
		$str=$_GET['stringsql'];
	}else{
		$str="";	
	}
	$declaracoes=mysql_query("SELECT DISTINCT SUBSTRING(periodo,6,2) FROM livro WHERE $codtipo='$codigo' AND SUBSTRING(periodo,1,4)='$anoselecionado' $str");
	if($competencia<10){
		$competencia = "0".$competencia;
	}
	while(list($competencia)=mysql_fetch_array($declaracoes)){
		echo "<option value='$competencia'>{$meses[$competencia]}</option>";
	}
}
echo "</select>";
}else{
	echo "<select id=\"cmbMes\" name=\"cmbMes\"></select>";	
}
?>