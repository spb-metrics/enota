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

// Pega as variaveis que vieram por POST
$data = date("Y-m-d");
$nome               = trataString($_POST['txtInsNomeEmpresa']);
$razaosocial        = trataString($_POST['txtInsRazaoSocial']);
$cpfcnpj            = $_POST['txtCNPJ'];
$logradouro         = trataString($_POST['txtLogradouro']);
$numero             = trataString($_POST['txtNumero']);
$complemento        = trataString($_POST['txtComplemento']);
$bairro             = trataString($_POST['txtBairro']);
$cep                = $_POST['txtCEP'];
$fone               = $_POST['txtFoneComercial'];
$celular            = $_POST['txtFoneCelular'];
$inscricaomunicipal = trataString($_POST['txtInsInscMunicipalEmpresa']);
$inscricaoestadual  = trataString($_POST['txtInsInscEstadualEmpresa']);
$pispasep           = trataString($_POST['txtPispasep']);
$email              = trataString($_POST['txtInsEmailEmpresa']);
$tipopessoa         = $_POST['cmbTipoPessoaEmpresa'];
$municipio          = $_POST['txtInsMunicipioEmpresa'];
$login              = $_POST['txtCNPJ'];
$senha              = $_POST['txtSenha'];
$simplesnacional    = $_POST['txtSimplesNacional'];
$CODCAT             = $_POST['txtMAXCODIGOCAT'];
$nfe                = $_POST['txtNfe'];
$uf                 = $_POST['txtInsUfEmpresa'];

	// define se � ou nao contador
    $sql=mysql_query("SELECT MAX(codigo) FROM servicos_categorias");
	list($maxcodigo)=mysql_fetch_array($sql);
	$sql_categoria=mysql_query("SELECT codigo FROM servicos_categorias WHERE nome LIKE '%Contabil%'");	
	list($codigocategoria)=mysql_fetch_array($sql_categoria);
	$categoria=1;
	$servico=1;
	$tipo="empresa";
	while($servico<=5){
		$nomecategoria=explode("|",$_POST['cmbCategoria'.$servico]);
		if($nomecategoria[0]=="$codigocategoria"){
				$tipo="contador";					
		}
				
		while($categoria<=$maxcodigo){
			if($_POST['cmbCodigo'.$categoria.$servico]!=""){$cmbCodigo="qualquercoisa";}
			$categoria++;	
		}	
		$servico++;	
	}
    if($tipo == "contador"){
        $sql = mysql_query("SELECT codigo FROM tipo WHERE tipo = 'contador'");
    }
    else{
        $sql = mysql_query("SELECT codigo FROM tipo WHERE tipo = 'prestador'");
    }
	
    list($codtipo)=mysql_fetch_array($sql);
    // define o tipo da declaracao
    if($simplesnacional){
        $sql=mysql_query("SELECT codigo FROM declaracoes WHERE declaracao = 'Simples Nacional'");
    }else{
        $sql=mysql_query("SELECT codigo FROM declaracoes WHERE declaracao = 'DES Consolidada'");
    }
    list($codtipodeclaracao)=mysql_fetch_array($sql);

    // verifca se o valor da variavel cpfcnpj e valido como cpf ou cmpj
    if((strlen($cpfcnpj)!=14)&&(strlen($cpfcnpj)!=18)){
		Mensagem('O CPF/CNPJ informado n&atilde;o &eacute; v&aacute;lido');      
	    echo "
			<script>
				window.location='../../prestadores.php';
			</script>
		";
    }

    //Verifica se n�o h� nenhuma empresa cadastrada com o mesmo nome e/ou cnpj
    $campo = tipoPessoa($cpfcnpj);
	$teste_nome        = mysql_query("SELECT codigo FROM cadastro WHERE nome = '$nome'");
	$teste_razaosocial = mysql_query("SELECT codigo FROM cadastro WHERE razaosocial = '$razaosocial'");
	$teste_cnpj        = mysql_query("SELECT codigo, codtipo FROM cadastro WHERE $campo = '$cpfcnpj'");
	
	$msg = "";
	$erro = 0;
	$codtipo_tomador = codtipo('tomador');
	
	if(mysql_num_rows($teste_cnpj)>0){
		$msg = "J&aacute; existe um prestador de servi&ccedil;os com este CPF/CNPJ";
		$erro = 2;
	}elseif(mysql_num_rows($teste_razaosocial)>0){
		$msg = "J&aacute; existe um prestador de servi&ccedil;os com esta razão social";
		$erro = 1;
	}elseif(mysql_num_rows($teste_nome)>0){
		$msg = "J&aacute; existe um prestador de servi&ccedil;os  com este nome";
		$erro = 1;
	}
		//
		if($erro == 1){
			Mensagem($msg);
			Redireciona('../../prestadores.php');
		}elseif($erro == 2){
			list($codigo,$codtipo) = mysql_fetch_array($teste_cnpj);
			if($codtipo == $codtipo_tomador){
				$acao = "atualizar";
			}else{
				Mensagem($msg);
				Redireciona('../../prestadores.php');
			}
		}else{
			$acao = "inserir";
		}
		
		// insere a empresa no banco
        $codtipo = codtipo('prestador');
		if($acao == "inserir"){
			$sql = mysql_query("
				INSERT INTO 
					cadastro
				SET 
					datainicio = '$data',
					nome = '$nome',
					senha = '".md5($senha)."',
					razaosocial = '$razaosocial',
					$campo = '$cpfcnpj',
					logradouro = '$logradouro',
					numero = '$numero',
					complemento = '$complemento',
					bairro = '$bairro',
					cep = '$cep',
					inscrmunicipal = '$inscricaomunicipal',
                    inscrestadual = '$inscricaoestadual',                  
					municipio ='$municipio',
					estado = 'NL',
					nfe = 'S',
					email = '$email',
					uf = '$uf',
					ultimanota = 0,
					fonecomercial = '$fone',
					fonecelular = '$celular',
					codtipo = '$codtipo',
					codtipodeclaracao = '$codtipodeclaracao',
					pispasep='$pispasep'
			") or die(mysql_error());
		}elseif($acao == "atualizar"){
			$sql = mysql_query("
				UPDATE 
					cadastro
				SET 
					datainicio = '$data',
					nome = '$nome',
					senha = '".md5($senha)."',
					razaosocial = '$razaosocial',
					$campo = '$cpfcnpj',
					logradouro = '$logradouro',
					numero = '$numero',
					complemento = '$complemento',
					bairro = '$bairro',
					cep = '$cep',
					inscrmunicipal = '$inscricaomunicipal',
                    inscrestadual = '$inscricaoestadual',                      
					municipio ='$municipio',
					estado = 'NL',
					nfe = 'S',
					email = '$email',
					uf = '$uf',
					ultimanota = 0,
					fonecomercial = '$fone',
					fonecelular = '$celular',
					codtipo = '$codtipo',
					codtipodeclaracao = '$codtipodeclaracao',
					pispasep='$pispasep'
				WHERE
					codigo = '$codigo'
			") or die(mysql_error());
		}
		
		
		//depois de cadastrada a empresa envia-se um passo a passo com  senha para a empresa cadastrada
	
		$sql_url_site = mysql_query("SELECT site, brasao_nfe FROM configuracoes");
		list($LINK_ACESSO) = mysql_fetch_array($sql_url_site);
		
		
		$imagemTratada = $_SERVER['HTTP_HOST']."/img/brasoes/".rawurlencode($CONF_BRASAO);
		$msg = "
		<a href=\"$LINK_ACESSO\" style=\"text-decoration:none\" ><img src=\"$imagemTratada\" alt=\"Bras&atilde;o Prefeitura\" title=\"Bras&atilde;o\" border=\"0\" width=\"100\" height=\"100\" /></a><br><br>
		O cadastro da empresa $nome foi efetuado com sucesso.<br>
		Dados da empresa:<br><br>
		Razão Social: $razaosocial<br>
		CPF/CNPJ: $cpfcnpj<br>
		Município: $municipio<br>
		Endereço: $logradouro, $numero<br><br>
		  
		Veja passo a passo como acessar o sistema:	<br><br>
		1- Acesse o site <a href=\"$LINK_ACESSO\"><b>NF-e</b></a><br>
		2- Entre em consulta, insira seu CNPJ/CPF e verifique se ja foi liberado seu acesso ao sistema<br>
		3- Clique no link Prestador<br>
		4- Entre em acessar o sistema<br>
		5- Em login insira o cpf/cnpf da empresa<br>
		6- Sua senha &eacute; <b><font color=\"RED\">$senha</font></b><br>
		7- Insira o c&oacute;digo de verifica&ccedil;&atilde;o que aparece ao lado<br>";
		
		$assunto = "Acesso ao Sistema NF-e ($CONF_CIDADE).";
	
		$headers  = "MIME-Version: 1.0\r\n";
	
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
	
		$headers .= "From: $CONF_SECRETARIA de $CONF_CIDADE <$CONF_EMAIL>  \r\n";
	
		$headers .= "Cc: \r\n";
	
		$headers .= "Bcc: \r\n";
		
		mail("$email",$assunto,$msg,$headers);
		
		
			
		
		// busca empresa no banco --------------------------------------------------------------------------------------------------		
		$sql_empresa = mysql_query("SELECT codigo FROM cadastro WHERE $campo = '$cpfcnpj'");
		list($CODEMPRESA) = mysql_fetch_array($sql_empresa);
	
		
	
		// INSERCAO DE SERVICOS POR EMPRESA INICIO----------------------------------------------------------------------------------		
			$nroservicos = 5;
			//$vetor_servicos = array($cmbCodigo1,$cmbCodigo2,$cmbCodigo3,$cmbCodigo4,$cmbCodigo5);		
		//Insere os servicos no banco...		
			
			//vetores para adicionar servicos
			 $sql_categoria=mysql_query("SELECT codigo,nome FROM servicos_categorias");
			 
			 $contpos=0;
			 while(list($codcategoria)=mysql_fetch_array($sql_categoria)) {   
			   $conts=1;
			   for($conts=1;$conts<=5;$conts++) {  
					$vetor_insere_servico[$contpos]=$_POST['cmbCodigo'.$codcategoria.$conts];
					if($_POST['cmbCodigo'.$codcategoria.$conts]){
						$sql = mysql_query("INSERT INTO cadastro_servicos
                                            SET codservico = '".$_POST['cmbCodigo'.$codcategoria.$conts]."',
                                            codemissor='$CODEMPRESA'");
					} 
					$contpos++;	
			   }		
			 }			
			
			
		// INSERCAO DE SERVICOS POR EMPRESA FIM
	
		// INSERCAO DE RESP/SOCIOS POR EMPRESA INICIO-------------------------------------------------------------------------------
		$contsocios = 0;
		$nrosocios = 10;
		
		$vetor_sociosnomes = array($txtNomeSocio1,$txtNomeSocio2,$txtNomeSocio3,$txtNomeSocio4,$txtNomeSocio5,$txtNomeSocio6,$txtNomeSocio7,$txtNomeSocio8,$txtNomeSocio9,$txtNomeSocio10);	
		$vetor_socioscpf = array($txtCpfSocio1,$txtCpfSocio2,$txtCpfSocio3,$txtCpfSocio4,$txtCpfSocio5,$txtCpfSocio6,$txtCpfSocio7,$txtCpfSocio8,$txtCpfSocio9,$txtCpfSocio10);	
	   //insere os socios no banco
		while($contsocios < $nrosocios) {   
			if($vetor_sociosnomes[$contsocios] != "") {
				//Especifica que na primeira posi��o ser� inserido um responsavel
                if($contsocios == 0){
                    $sql_cargo = mysql_query("SELECT codigo FROM cargos WHERE cargo = 'diretor'");
                }else{
                    $sql_cargo = mysql_query("SELECT codigo FROM cargos WHERE cargo = 'socio'");
                }
                list($codcargo)=mysql_fetch_array($sql_cargo);
				$sql = mysql_query("INSERT INTO cadastro_resp
                                    SET codemissor = '$CODEMPRESA',
                                    nome = '$vetor_sociosnomes[$contsocios]',
                                    cpf = '$vetor_socioscpf[$contsocios]',
                                    codcargo = '$codcargo'");

			} // fim if	
			$contsocios++;
	   } // fim while   
		// INSERCAO DE RESP/SOCIOS POR EMPRESA FIM
		
	   
		//gera o comprovante em pdf 
		$CodEmp = base64_encode($CODEMPRESA);
		Mensagem('Empresa cadastrada! N&atilde;o esque&ccedil;a de Imprimir o comprovante de cadastro que abrir&aacute; em uma nova janela!');
		print "
			<script language='javascript' type='text/javascript' charset=\"utf-8\">
				window.open('../../../reports/cadastro_comprovante.php?COD=$CodEmp');
				window.location='../../prestadores.php';
			</script>
		"; 
?>
