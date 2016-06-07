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
    include("../conect.php");
    include("../../funcoes/util.php");
    $codempreiteira=$_GET['cmbEmpreiteira'];
    $coddecc_des=$_GET['hdCodSolicitacao'];

    $sql_auditoria=mysql_query("SELECT DATE_FORMAT(decc_des.competencia, '%Y/%m') AS competencia,
                                decc_des.codverificacao,
                                decc_des.estado,
                                DATE_FORMAT(des_issretido.competencia, '%Y/%m') AS competenciaissretido,
                                des_issretido.codverificacao AS codigoverificaissretido,
                                des_issretido.estado AS estadoisssretido,
                                des_issretido.codigo AS codissretido,
                                tomadores.nome AS tomador,
                                tomadores.cnpjcpf
                                FROM decc_des
                                INNER JOIN des_issretido_notas
                                ON decc_des.codempreiteira=des_issretido_notas.codrelacionamento
                                INNER JOIN des_issretido
                                ON des_issretido_notas.coddes_issretido=des_issretido.codigo
                                INNER JOIN tomadores
                                ON des_issretido.codtomador=tomadores.codigo
                                WHERE des_issretido_notas.relacionamento='empreiteiras'
                                AND decc_des.codigo='$coddecc_des'
                                AND decc_des.codempreiteira='$codempreiteira'
                                AND decc_des.data=des_issretido.data_gerado");
    if(mysql_num_rows($sql_auditoria)){
        $dados_auditoria=mysql_fetch_array($sql_auditoria);

        // trata o estado da declaracao da empreiteira
        if($dados_auditoria['estado']=="N"){
            $dados_auditoria['estado']="Normal";
        }elseif($dados_auditoria['estado']=="C"){
            $dados_auditoria['estado']="Cancelada";
        }elseif($dados_auditoria['estado']=="B"){
            $dados_auditoria['estado']="Boleto";
        }else{
            $dados_auditoria['estado']="Escriturada";
        }

        // trata o estado da declaracao do tomador
        if($dados_auditoria['estadoissretido']=="N"){
            $dados_auditoria['estadoissretido']="Normal";
        }elseif($dados_auditoria['estadoissretido']=="C"){
            $dados_auditoria['estadoissretido']="Cancelada";
        }elseif($dados_auditoria['estadoissretido']=="B"){
            $dados_auditoria['estadoissretido']="Boleto";
        }else{
            $dados_auditoria['estadoissretido']="Escriturada";
        }
        ?>
            <fieldset><legend>Resultados</legend>
                <table align="center" width="100%">
                    <tr align="left">
                        <td>Tomador:</td>
                        <td><?php echo $dados_auditoria['tomador']; ?></td>
                    </tr>
                    <tr align="left">
                        <td>CNPJ/CPF Tomador:</td>
                        <td><?php echo $dados_auditoria['cnpjcpf']; ?></td>
                    </tr>
                    <tr align="left">
                        <td>C�d. Verifica��o Declara��o do Tomador:</td>
                        <td><?php echo $dados_auditoria['codigoverificaissretido']; ?></td>
                    </tr>
                    <tr align="left">
                        <td>C�d. Verifica��o Declara��o da Empreiteira:</td>
                        <td><?php echo $dados_auditoria['codverificacao']; ?></td>
                    </tr>
                    <tr align="left">
                        <td>Compet�ncia Declara��o do Tomador:</td>
                        <td><?php echo $dados_auditoria['competenciaissretido']; ?></td>
                    </tr>
                    <tr align="left">
                        <td>Compet�ncia Declara��o da Empreiteira:</td>
                        <td><?php echo $dados_auditoria['competencia']; ?></td>
                    </tr>
                    <tr align="left">
                        <td>Estado Declara��o do Tomador:</td>
                        <td><?php echo $dados_auditoria['estadoissretido']; ?></td>
                    </tr>
                    <tr align="left">
                        <td>Estado Declara��o da Empreiteira:</td>
                        <td><?php echo $dados_auditoria['estado']; ?></td>
                    </tr>
                </table>
            </fieldset>
        <?php
    }

    // busca as notas relacionadas com a declaracao do tomador
    $sql_notas_tomador=mysql_query("SELECT nota_nro AS numero, valor_nota AS valor FROM des_issretido_notas WHERE coddes_issretido='".$dados_auditoria['codissretido']."'");
    $sql_notas_prestador=mysql_query("SELECT nronota AS numero, valornota AS valor FROM decc_des_notas WHERE coddecc_des='$coddecc_des'");
    ?>
        <fieldset><legend>Notas relacionadas na Declara��o do Tomador</legend>
            <table width="50%" align="center">
                <tr align="center" bgcolor="999999">
                    <td>N�mero</td>
                    <td>Valor R$</td>
                </tr>
                <?php
                    while($dados=mysql_fetch_array($sql_notas_tomador)){
                        echo "
                            <tr align=\"center\" bgcolor=\"FFFFFF\">
                                <td>".$dados['numero']."</td>
                                <td>".$dados['valor']."</td>
                            </tr>
                        ";
                    }
                ?>
            </table>
        </fieldset>
        <fieldset><legend>Notas Relacionadas na Declara��o da Empreiteira</legend>
            <table width="50%" align="center">
                <tr align="center" bgcolor="999999">
                    <td>N�mero</td>
                    <td>Valor R$</td>
                </tr>
                <?php
                    while($dados=mysql_fetch_array($sql_notas_prestador)){
                        echo "
                            <tr align=\"center\" bgcolor=\"FFFFFF\">
                                <td>".$dados['numero']."</td>
                                <td>".$dados['valor']."</td>
                            </tr>
                        ";
                    }
                ?>
            </table>
        </fieldset>
    <?php
?>