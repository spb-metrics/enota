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
include("../../inc/conect.php");
include("../../funcoes/util.php");

$sql_brasao = mysql_query("SELECT brasao_nfe FROM configuracoes");
//preenche a variavel com os valores vindos do banco
list($BRASAO) = mysql_fetch_array($sql_brasao);
?>

<title>Imprimir Relat&oacute;rio</title>

<style type="text/css" media="screen">
<!--
.style1 {font-family: Georgia, "Times New Roman", Times, serif}

.tabela {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-collapse:collapse;
	border: 1px solid #000000;
}
.tabelameio {
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	border-collapse:collapse;
	border: 1px solid #000000;
}
.tabela tr td{
	border: 1px solid #000000;
}
.fonte{
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
}
div.pagina {
    writing-mode: tb-rl;
    height: 100%;
    /*margin: 10% 0%;*/
}
-->
</style>
<style type="text/css" media="print">
    #DivImprimir{
        display: none;
}
</style>
</head>
<?php
	$codigo = $_POST['rdbGuia'];
	$codtipo = $_POST['rdbTipo'];
?>
<body>
    <div class="pagina">
        <div id="DivImprimir">
            <input type="button" onClick="print();" value="Imprimir" />
            <br />
            <i><b>Este relat&oacute;rio &eacute; melhor visualizado em formato de impress&atilde;o em paisagem.</b></i>
            <br /><br />
        </div>
        <center>

        <table width="95%" height="120" border="2" cellspacing="0" class="tabela">
          	<tr>
            	<td width="106">
					<center>
						<img src="../../img/brasoes/<?php print $BRASAO; ?>" width="96" height="105"/>
					</center>
				</td>
            	<td width="584" height="33" colspan="2">
					<span class="style1">
					<center>
						 <p>RELAT&Oacute;RIO DE D&Iacute;VIDAS ATIVAS </p>
						 <p>PREFEITURA MUNICIPAL DE <?php print strtoupper($CONF_CIDADE); ?> </p>
						 <p><?php print strtoupper($CONF_SECRETARIA); ?> </p>
					</center>
					</span>
				</td>
			</tr>
		</table>
        <br />
        
        <?php
			$data = date('Y-m-d');
			$ano = date('Y');
			$dia = date('d');
			$mes = $_POST['cmbMes'];
				if($mes){
					$where = "AND datavencimento LIKE '%-$mes-%'";
				}
			if($codigo == 'codnota'){
				$campos='
					nota.tomador_nome, 
					nota.tomador_cnpjcpf, 
				    nota.codverificacao,
				    nota.codigo AS codnota';
				$join='
					LEFT JOIN 
						notas AS nota
					ON
						nota.codigo = guia.codnota
					LEFT JOIN 
						cadastro
					ON
						cadastro.codigo = nota.codemissor
					';
			}else{
				$campos='
					livro.codigo, 
				    livro.periodo,
				    livro.codcadastro AS codcadatro';
				$join='
					LEFT JOIN 
						livro
					ON
						livro.codigo = guia.codlivro
					LEFT JOIN 
						cadastro
					ON
						cadastro.codigo = livro.codcadastro';
			}
			
			$query =("SELECT 
						   guia.codigo AS codguia, 
						   guia.dataemissao, 
						   guia.datavencimento, 
						   guia.valor AS total, 
						   guia.valormulta AS multa, 
						   guia.pago AS pago, 
						   guia.estado, 
						   guia.motivo_cancelamento, 
						   guia.codlivro, 
						   guia.codnota AS codnota,
						   cadastro.nome,
						   cadastro.cnpj,
						   cadastro.cpf,
						   cadastro.codtipo,
						   $campos
					FROM 
						guia_pagamento AS guia
					$join
					
					WHERE pago = 'N' AND guia.estado = 'N' AND datavencimento < '$data' AND cadastro.codtipo = '$codtipo' AND $codigo <> '' $where
					ORDER BY guia.datavencimento
					");
		
		$sql_pesquisa = mysql_query ($query);
		$result = mysql_num_rows($sql_pesquisa);
		if(mysql_num_rows($sql_pesquisa)){
        ?>
        
        <table width="95%" class="tabela" border="1" cellspacing="0" style="page-break-after: always">
            	<tr style="background-color:#999999">
					<?php
					if($result <= 1){
						echo "<b>Foi encontrado $result  Resultado</b>";
					}else{
						echo "<b>Foram encontrados $result  Resultados</b>";
					}
					?>
					<td width="40%" align="center">
						<strong>Nome</strong>
					</td>
					<td width="20%" align="center">
						<strong>CPF/CNPJ</strong>
					</td>
					<td width="10%" align="center">
						<strong>Data Vencimento</strong>
					</td>
                    <td width="10%" align="center">
						<strong>Valor</strong>
					</td>
                    <td width="10%" align="center">
						<strong>Multa</strong>
					</td>
                    <td width="10%" align="center">
						<strong>Total</strong>
					</td>
          		</tr>
				<?php
					while ($dados = mysql_fetch_array($sql_pesquisa)){
						if($dados['cpf'] == ''){
							$cpfcnpj = $dados['cnpj'];
						}else{
							$cpfcnpj = $dados['cpf'];
						}
						$total = $dados['total'];
						$multa = $dados['multa'];
			 	?>
				<tr>
					<td bgcolor="white" align="left">
						<font size="1"><?php echo $dados['nome']; ?></font>
					</td>
					<td bgcolor="white" align="center">
						<font size="1"><?php echo $cpfcnpj; ?></font>
					</td>
                    <td bgcolor="white" align="center">
						<font size="1"><?php echo DataPt($dados['datavencimento']); ?></font>
					</td>
					<td bgcolor="white" align="center">
						<font size="1"><?php echo "R$  ".DecToMoeda($dados['total']); ?></font>
					</td>
                    <td bgcolor="white" align="center">
						<font size="1"><?php echo "R$  ".DecToMoeda($multa); ?></font>
					</td>
					<td bgcolor="white" align="center">
						<font size="1"><?php echo "R$ ".DecToMoeda($total + $multa); ?></font>
					</td>
				</tr>
        	<?php
					}//fim while
			}else{
			?>
            <table width="95%" class="tabela" border="1" cellspacing="0" style="page-break-after: always" align="center">
                <tr style="background-color:#999999;font-weight:bold;" align="center">
                    <td>N&atilde;o h&aacute; resultados!</td>
                </tr>
            </table>
            <?php 
        	}
        	?>
        	</table>
      
		</center>
	</div>
</body>
</html>