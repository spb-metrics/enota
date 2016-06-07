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
	//Conecta ao banco
	require_once('../../conect.php');
	require_once('../../../funcoes/util.php');
	
	//Recebe as variaveis enviadas pelo form por get
	$nome        = $_GET['txtNome'];
	$cnpj        = $_GET['txtCNPJ'];
	$compmes     = $_GET['cmbMes'];
	$compano     = $_GET['cmbAno'];
	$data        = $_GET['txtData'];
	$estado      = $_GET['cmbEstado'];
	$numero      = $_GET['txtNroDecc'];
	$cancelaDecc = $_GET['hdCancelaDecc'];
	
	//se foi cancelada alguma declara��o da o updade no banco e da um alert se der algum erro
	if($cancelaDecc){
		mysql_query("UPDATE decc_des SET estado = 'C' WHERE codigo = '$cancelaDecc'");
		add_logs('Atualizou uma Declara��o');
	}//fim if cacela
	
	//verifica quais campos foram preenchidos e concatena na variavel str_where
	if($compmes){
		$str_where = " AND MONTH(decc_des.competencia) = '$compmes'";
	}
	if($compano){
		$str_where .= " AND YEAR(decc_des.competencia) = '$compano'";
	}
	if($data){
		$data = DataMysql($data);
		$str_where .= " AND decc_des.data = '$data'";
	}
	if($cnpj){
		$str_where .= " AND empreiteiras.cnpj = '$cnpj'";
	}
	if($estado){
		$str_where .= " AND decc_des.estado = '$estado'";
	}
	if($numero){
		$str_where .= " AND decc_des.codigo = '$numero'";
	}
	
	//Sql buscando as informa��es que o usuario pediu e com o limit estipulado pela fun��o
	$query = ("
			SELECT 
				decc_des.codigo,
				decc_des.data,
				decc_des.total,
				decc_des.iss,
				decc_des.codverificacao,
				decc_des.estado,
				decc_des.competencia,
				empreiteiras.nome
			FROM 
				decc_des
			INNER JOIN
				cadastro as empreiteiras ON decc_des.codempreiteira = empreiteiras.codigo
			WHERE 
				(empreiteiras.nome LIKE '$nome%' OR empreiteiras.razaosocial LIKE '$nome%') $str_where
			ORDER BY 
				decc_des.codigo
			DESC");
	$sql_pesquisa = Paginacao($query,'frmEmpreiteiras','divDeclaracoesEmpreiteiras',10);
if(mysql_num_rows($sql_pesquisa)){
?>
<table width="100%">
	<tr bgcolor="#999999">
    	<td width="7%" align="center">N&deg; Dec</td>
        <td width="38%" align="center">Nome</td>
        <td width="15%" align="center">Data</td>
        <td width="13%" align="center">Competencia</td>
        <td width="13%" align="center">Estado</td>
        <td width="14%" colspan="2" align="center"></td>
  </tr>
    <?php
		$x = 0;
		while($dados_pesquisa = mysql_fetch_array($sql_pesquisa)){
			//alterna o valor da variavel pelo seu valor por extenso
			switch($dados_pesquisa['estado']){
				case "B": $str_estado = "Boleto";      break;
				case "N": $str_estado = "Normal";      break;
				case "C": $str_estado = "Cancelada";   break;
				case "E": $str_estado = "Escriturada"; break;		
			}
			if($dados_pesquisa['estado'] == "C"){
				$bgcolor = "#FFAC84";
			}else{
				$bgcolor = "#FFFFFF";
			}
	?>
    <input type="hidden" name="txtCodigoGuia<?php echo $x;?>" id="txtCodigoGuia<?php echo $x;?>" value="<?php echo $dados_pesquisa['codigo'];?>" />
    <tr id="trDecc<?php echo $x;?>">
    	<td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo $dados_pesquisa['codigo'];?></td>
        <td bgcolor="<?php echo $bgcolor;?>" align="left"><?php echo $dados_pesquisa['nome'];?></td>
     	<td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo DataPt($dados_pesquisa['data']);?></td>
        <td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo DataPt($dados_pesquisa['competencia']);?></td>
        <td bgcolor="<?php echo $bgcolor;?>" align="center"><?php echo $str_estado;?></td>
<td bgcolor="#FFFFFF" align="left" colspan="2">&nbsp;
        	<label title="Ver Detalhes">
        		<input name="btDetalhesDecc" id="btLupa" type="button" class="botao" value="" 
            	onClick="VisualizarNovaLinha('<?php echo $dados_pesquisa['codigo'];?>','<?php echo"tddecc".$x;?>',this,'inc/declaracoes/decc/declarar_vizualizar.ajax.php')">
            </label>
            &nbsp;
            <?php if($dados_pesquisa['estado'] != "C"){?>
            <label title="Cancelar Declara��o" id="lbCancelar<?php echo $x;?>">
            	<input name="btCancelarDecc" id="btX" type="button" class="botao" value=""
                onClick="document.getElementById('hdPrimeiro').value=1; return cancelarDeclaracao('<?php echo $dados_pesquisa['codigo'];?>','<?php echo $dados_pesquisa['nome'];?>','inc/declaracoes/decc/declarar_pesquisa.ajax.php','frmEmpreiteiras','divDeclaracoesEmpreiteiras','hdCancelaDecc');">
            </label>
            <?php }?>
        </td>
    </tr>
    <tr id="trDeccOculta<?php echo $x;?>">
        <td id="<?php echo"tddecc".$x; ?>" colspan="7" align="center"></td>
    </tr>
    <?php
			$x++;
		}//fim while
	?>
    <input name="hdCodDelDecc" id="hdCodDelDecc" type="hidden">
</table>
<?php
}else{
	echo "<center><b>N�o h� resultados!</b></center>";
}
?>

