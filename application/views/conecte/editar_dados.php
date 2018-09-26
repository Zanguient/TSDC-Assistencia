<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-user"></i>
                </span>
                <h5><?=$this->lang->line('conecteeditadados');?></h5>
            </div>
            <div class="widget-content nopadding">
              
                <form action="<?php echo current_url(); ?>" id="formCliente" method="post" class="form-horizontal" >
                    <div class="control-group">
                        <input type="hidden" name="idClientes" id="idClientes" value="<?php echo $result->idClientes; ?>" />   
                        <label for="nomeCliente" class="control-label"><?=$this->lang->line('conecteeditanome');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="nomeCliente" type="text" name="nomeCliente" value="<?php echo $result->nomeCliente; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="documento" class="control-label"><?=$this->lang->line('conecteeditacpfcnpj');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="documento" type="text" name="documento" value="<?php echo $result->documento; ?>"  />
                        </div>
                    </div>
                    <div class="control-group">
                        <label for="telefone" class="control-label"><?=$this->lang->line('conecteeditatelfxo');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="telefone" type="text" name="telefone" value="<?php echo $result->telefone; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="celular" class="control-label"><?=$this->lang->line('conecteeditatelmovel');?></label>
                        <div class="controls">
                            <input id="celular" type="text" name="celular" value="<?php echo $result->celular; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="email" class="control-label"><?=$this->lang->line('conecteeditaemail');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="email" type="text" name="email" value="<?php echo $result->email; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="rua" class="control-label"><?=$this->lang->line('conecteeditaend');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="rua" type="text" name="rua" value="<?php echo $result->rua; ?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="numero" class="control-label"><?=$this->lang->line('conecteeditaendnum');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="numero" type="text" name="numero" value="<?php echo $result->numero; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="bairro" class="control-label"><?=$this->lang->line('conecteeditaendbairro');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="bairro" type="text" name="bairro" value="<?php echo $result->bairro; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="cidade" class="control-label"><?=$this->lang->line('conecteeditaendciti');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="cidade" type="text" name="cidade" value="<?php echo $result->cidade; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="estado" class="control-label"><?=$this->lang->line('conecteeditaendus');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="estado" type="text" name="estado" value="<?php echo $result->estado; ?>"  />
                        </div>
                    </div>

                    <div class="control-group" class="control-label">
                        <label for="cep" class="control-label"><?=$this->lang->line('conecteeditaendcep');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="cep" type="text" name="cep" value="<?php echo $result->cep; ?>"  />
                        </div>
                    </div>



                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-primary"><i class="icon-ok icon-white"></i><?=$this->lang->line('conecteeditaedita');?></button>
                                <a href="<?php echo base_url() ?>conecte/conta" id="" class="btn"><i class="icon-arrow-left"></i><?=$this->lang->line('conecteeditavolta');?></a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url()?>js/jquery.validate.js"></script>
<script type="text/javascript">
      $(document).ready(function(){
           $('#formCliente').validate({
            rules :{
                  nomeCliente:{ required: true},
                  documento:{ required: true},
                  telefone:{ required: true},
                  email:{ required: true},
                  rua:{ required: true},
                  numero:{ required: true},
                  bairro:{ required: true},
                  cidade:{ required: true},
                  estado:{ required: true},
                  cep:{ required: true}
            },
            messages:{
                  nomeCliente :{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  documento :{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  telefone:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  email:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  rua:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  numero:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  bairro:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  cidade:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  estado:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'},
                  cep:{ required: '<?=$this->lang->line('conecteeditaobrigatorio');?>'}

            },

            errorClass: "help-inline",
            errorElement: "span",
            highlight:function(element, errorClass, validClass) {
                $(element).parents('.control-group').addClass('error');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).parents('.control-group').removeClass('error');
                $(element).parents('.control-group').addClass('success');
            }
           });
      });
</script>

