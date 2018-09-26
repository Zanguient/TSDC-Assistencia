<?php $totalServico = 0; $totalProdutos = 0;?>
<style type="text/css">
    @media print{button.assinatura_cliente{display:none;}}
</style>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Ordem de Serviço</h5>
                <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eOs')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.site_url('os/editar/').$result->idOs.'"><i class="icon-pencil icon-white"></i> Editar</a>';
                    } ?>

                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content" id="printOs">
                <div class="invoice-content">
                    <div class="invoice-head" style="margin-bottom: 0">

                        <table class="table">
                            <tbody>
                                <?php if($emitente == null) {?>

                                <tr>
                                    <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?=site_url('index.php/tsdc/emitente')?>">Configurar</a><<<</td>
                                </tr>
                                <?php } else {?>
                                <tr>
                                    <td style="width: 25%"><img src=" <?=$emitente[0]->url_logo?> "></td>
                                    <td> <span style="font-size: 20px; "> <?=$emitente[0]->nome?></span> </br><span><?=$emitente[0]->cnpj?> </br>
                                      <?=$emitente[0]->rua.', nº:'.$emitente[0]->numero.', '.$emitente[0]->bairro.' - '.$emitente[0]->cidade.' - '.$emitente[0]->uf?> </span> </br> <span> E-mail: <?=$emitente[0]->email.' - Fone: '.$emitente[0]->telefone?></span></td>
                                      <td style="width: 18%; text-align: center">#Protocolo: <span ><?=$result->idOs?></span></br> </br> <span>Emissão: <?=date('d/m/Y')?></span></td>
                                  </tr>

                                  <?php } ?>
                              </tbody>
                          </table>


                          <table class="table">
                            <tbody>
                                <tr>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span><h5>Cliente</h5>
                                                    <span><?=$result->nomeCliente?></span><br/>
                                                    <span><?=$result->clienteCelular?> / <?=$result->clienteTelefone?> </span><br/>
                                                    <span><?=$result->rua?>, <?=$result->numero?>, <?=$result->bairro?></span><br/>
                                                    <span><?=$result->cidade?> - <?=$result->estado?></span>
                                                </li>
                                            </ul>
                                        </td>
                                        <td style="width: 50%; padding-left: 0">
                                            <ul>
                                                <li>
                                                    <span><h5>Responsável</h5></span>
                                                    <span><?=$result->nome?></span> <br/>
                                                    <span>Telefone: <?=$result->telefone?></span><br/>
                                                    <span>Email: <?=$result->email?></span>
                                                </li>
                                            </ul>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                        </div>

                        <div style="margin-top: 0; padding-top: 0">

                            <hr style="margin-top: 0">
                            <h5>Dados Produto</h5>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Fabricante</th>
                                        <th>Modelo</th>
                                        <th>Tipo de Equipamento</th>
                                        <th>Nº de Série</th>
                                        <th>Part Namber</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?=$result->fabricante?></td>
                                        <td><?=$result->modelo?></td>
                                        <td><?=$result->tipo_equipamento?></td>
                                        <td><?=$result->serie?></td>
                                        <td><?=$result->part_namber?></td>
                                    </tr>
                                </tbody>
                            </table>

                            <?php if($result->descricaoProduto != null){?>
                            <hr style="margin-top: 0">
                            <h5>Descrição</h5>
                            <p>
                                <?=$result->descricaoProduto?>

                            </p>
                            <?php }?>

                            <?php if($result->defeito != null){?>
                            <hr style="margin-top: 0">
                            <h5>Defeito</h5>
                            <p>
                                <?=$result->defeito?>
                            </p>
                            <?php }?>
                            <?php if($result->laudoTecnico != null){?>
                            <hr style="margin-top: 0">
                            <h5>Laudo Técnico</h5>
                            <p>
                                <?=$result->laudoTecnico?>
                            </p>
                            <?php }?>
                            <?php if($result->observacoes != null){?>
                            <hr style="margin-top: 0">
                            <h5>Observações</h5>
                            <p>
                                <?=$result->observacoes?>
                            </p>
                            <?php }?>

                            <?php if($produtos != null){?>
                            <br />
                            <table class="table table-bordered" id="tblProdutos">
                                <thead>
                                    <tr>
                                        <th>Produto</th>
                                        <th>Valor</th>
                                        <th>Quantidade</th>
                                        <th>Desconto</th>
                                        <th>Sub-total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $totalProduto = 0;
                                    $descontoTotalProduto = 0;
                                    $precoVendaProduto = 0;
                                    foreach ($produtos as $p) {

                                        $descontoTotalProduto += $p->desconto;
                                        $precoVendaProduto += $p->precoVenda * $p->quantidade;
                                        $totalProduto += $p->subTotal;
                                        echo '<tr>';
                                        echo '<td>'.$p->descricao.'</td>';
                                        echo '<td>R$ '.number_format($p->precoVenda, 2, ',', '.').'</td>';
                                        echo '<td>'.$p->quantidade.'</td>';
                                        echo '<td>R$ '.number_format($p->desconto, 2, ',', '.').'</td>';

                                        echo '<td>R$ '.number_format($p->subTotal,2,',','.').'</td>';
                                        echo '</tr>';
                                    }?>

                                    <tr>
                                        <td style="text-align: left"><strong>Total:</strong></td>
                                        <td style="text-align: center" colspan="2"><strong>R$ <?=number_format($precoVendaProduto,2,',','.');?></strong></td>
                                        <td style="text-align: center"><strong>R$ <?=number_format($descontoTotalProduto,2,',','.');?></strong></td>
                                        <td style="text-align: center" colspan="2"><strong>R$ <?=number_format($totalProduto,2,',','.');?><input type="hidden" id="total-venda" value="<?=number_format($totalProduto,2); ?>"></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php }?>

                            <?php if($servicos != null){?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Serviço</th>
                                        <th>Valor</th>
                                        <th>Desconto</th>
                                        <th>Sub-total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subTotalServicos = 0;
                                    $totalDescontoServicos = 0;
                                    $totalServicos = 0;
                                    setlocale(LC_MONETARY, 'en_US');
                                    foreach ($servicos as $s) {
                                        $subTotalServicos += $s->subTotal;
                                        $totalDescontoServicos += $s->desconto;
                                        $totalServicos += $s->preco;
                                        echo '<tr>';
                                        echo '<td>'.$s->nome.'</td>';
                                        echo '<td>R$ '.number_format($s->preco, 2, ',', '.').'</td>';
                                        echo '<td>R$ '.number_format($s->desconto, 2, ',', '.').'</td>';
                                        echo '<td>R$ '.number_format($s->preco - $s->desconto, 2, ',', '.').'</td>';
                                        echo '</tr>';
                                    }?>

                                    <tr >
                                        <td style="text-align: left"><strong>Total:</strong></td>
                                        <td style="text-align: center"><strong>R$ <?=number_format($totalServicos,2,',','.');?></strong></td>
                                        <td style="text-align: center"><strong>R$ <?=number_format($totalDescontoServicos,2,',','.');?></strong></td>
                                        <td style="text-align: center"><strong>R$ <?=number_format($subTotalServicos,2,',','.');?></strong></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php }?>
                            <hr />

                            <h6 style="text-align: right">Subtotal: R$ <?=number_format($result->valorTotal,2,',','.')?></h6>
                            <h6 style="text-align: right">Desconto Total: R$ <?=number_format($result->descontoTotal,2,',','.')?></h6>
                            <h4 style="text-align: right">Valor Total: R$ <?=number_format($result->valorTotal - $result->descontoTotal,2,',','.')?></h4>
                            <span class="assinatura_cliente">
                                <h5 style="text-align:left">Recebido por:____________________________________</h5>
                                <h5 style="text-align:left">Data: ____/____/________</h5>
                                <h5 style="text-align:left">Assinatura: _____________________________________</h5>
                            </span>
                            <button class="assinatura_cliente" onclick="$('.assinatura_cliente').remove();">Remover Assinatura</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function(){
            $("#imprimir").click(function(){
                $('button.assinatura_cliente').remove();
                PrintElem('#printOs');
            })

            function PrintElem(elem)
            {
                Popup($(elem).html());
            }

            function Popup(data)
            {
                var mywindow = window.open('', 'mydiv', 'height=600,width=800');
                mywindow.document.open();
                mywindow.document.onreadystatechange=function(){
                  if(this.readyState==='complete'){
                     this.onreadystatechange=function(){};
                     mywindow.focus();
                     mywindow.print();
                     mywindow.close();
                 }
             }
             mywindow.document.write('<html><head><title>TSDC</title>');
             mywindow.document.write("<link rel='stylesheet' href='<?=base_url('assets/css/bootstrap.min.css')?>' />");
             mywindow.document.write("<link rel='stylesheet' href='<?=base_url('assets/css/bootstrap-responsive.min.css')?>' />");
             mywindow.document.write("<link rel='stylesheet' href='<?=base_url('assets/css/matrix-style.css')?>' />");


             mywindow.document.write('</head><body >');
             mywindow.document.write(data);
             mywindow.document.write('</body></html>');

             mywindow.document.close();

             return true;
         }

     });
 </script>
