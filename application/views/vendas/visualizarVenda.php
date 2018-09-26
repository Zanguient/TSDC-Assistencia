<?php $totalProdutos = 0;?>
<div class="row-fluid" style="margin-top: 0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-tags"></i>
                </span>
                <h5>Venda</h5>
                <div class="buttons">
                    <?php if($this->permission->checkPermission($this->session->userdata('permissao'),'eVenda')){
                        echo '<a title="Icon Title" class="btn btn-mini btn-info" href="'.site_url('vendas/editar/'.$result->idVendas).'"><i class="icon-pencil icon-white"></i> Editar</a>';
                    } ?>

                    <a id="imprimir" title="Imprimir" class="btn btn-mini btn-inverse" href=""><i class="icon-print icon-white"></i> Imprimir</a>
                </div>
            </div>
            <div class="widget-content" id="printOs">
                <div class="invoice-content">
                    <div class="invoice-head">
                        <table class="table">
                            <tbody>

                                <?php if($emitente == null) {?>

                                <tr>
                                    <td colspan="3" class="alert">Você precisa configurar os dados do emitente. >>><a href="<?=site_url('mapos/emitente')?>">Configurar</a><<<</td>
                                </tr>
                                <?php } else {?>

                                <tr>
                                    <td style="width: 25%"><img src=" <?=$emitente[0]->url_logo?> "></td>
                                    <td> <span style="font-size: 20px; "> <?=$emitente[0]->nome?></span> </br><span><?=$emitente[0]->cnpj?> </br> <?=$emitente[0]->rua.', nº:'.$emitente[0]->numero.', '.$emitente[0]->bairro.
                                    ' - '.$emitente[0]->cidade.' - '.$emitente[0]->uf?> </span> </br> <span> E-mail: <?=$emitente[0]->email.
                                    ' - Fone: '.$emitente[0]->telefone?></span></td>
                                    <td style="width: 18%; text-align: center">#Venda: <span ><?=$result->idVendas?></span></br> </br> <span>Emissão: <?=date('d/m/Y')?></span></td>
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
                                                <span><?=$result->rua?>, <?=$result->numero?>, <?=$result->bairro?></span><br/>
                                                <span><?=$result->cidade?> - <?=$result->estado?></span>
                                            </li>
                                        </ul>
                                    </td>
                                    <td style="width: 50%; padding-left: 0">
                                        <ul>
                                            <li>
                                                <span><h5>Vendedor</h5></span>
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


                        <?php if($produtos != null){?>

                        <table class="table table-bordered table-condensed" id="tblProdutos">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 15px">Produto</th>
                                            <th style="font-size: 15px">Valor Unitário</th>
                                            <th style="font-size: 15px">Quantidade</th>
                                            <th style="font-size: 15px">Desconto</th>
                                            <th style="font-size: 15px">Sub-total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        foreach ($produtos as $p) {

                                            $totalProdutos = $totalProdutos + $p->subTotal;
                                            echo '<tr>';
                                            echo '<td>'.$p->descricao.'</td>';
                                            echo '<td>'.$p->precoVenda.'</td>';
                                            echo '<td>'.$p->quantidade.'</td>';
                                            echo '<td>'.$p->desconto.'</td>';

                                            echo '<td>R$ '.number_format($p->subTotal - $p->desconto,2,',','.').'</td>';
                                            echo '</tr>';
                                        }?>

                                        <tr>
                                            <td colspan="4" style="text-align: right"><strong>Total:</strong></td>
                                            <td><strong>R$ <?=number_format($result->valorTotal - $result->descontoTotal,2,',','.')?></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                               <?php }?>


                        <hr />
                        <h4 style="text-align: right">Sub Total: R$ <?=number_format($result->valorTotal,2,',','.')?></h4>
                        <h4 style="text-align: right">Desconto Total: R$ <?=number_format($result->descontoTotal,2,',','.')?></h4>
                        <h4 style="text-align: right">Valor Total: R$ <?=number_format($result->valorTotal - $result->descontoTotal,2,',','.')?></h4>

                    </div>





                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#imprimir").click(function(){
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
            mywindow.document.write('<html><head><title>Map Os</title>');
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
