<div class="row-fluid" style="margin-top:0">
    <div class="span12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="icon-align-justify"></i>
                </span>
                <h5><?=$this->lang->line('prodaddprodtitulocad');?></h5>
            </div>
            <div class="widget-content nopadding">
                <?=$custom_error?>
                <form action="<?=current_url()?>" id="formProduto" method="post" class="form-horizontal" >
                     <div class="control-group">
                        <label for="descricao" class="control-label"><?=$this->lang->line('prodaddproddesc');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="descricao" type="text" name="descricao" value="<?=set_value('descricao')?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="unidade" class="control-label"><?=$this->lang->line('prodaddprodund');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="unidade" type="text" name="unidade" value="<?=set_value('unidade')?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="precoCompra" class="control-label"><?=$this->lang->line('prodaddprodpccom');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoCompra" class="money" type="text" name="precoCompra" value="<?=set_value('precoCompra')?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="precoVenda" class="control-label"><?=$this->lang->line('prodaddprodpcven');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="precoVenda" class="money" type="text" name="precoVenda" value="<?=set_value('precoVenda')?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="estoque" class="control-label"><?=$this->lang->line('prodaddprodstoq');?><span class="required">*</span></label>
                        <div class="controls">
                            <input id="estoque" type="text" name="estoque" value="<?=set_value('estoque')?>"  />
                        </div>
                    </div>

                    <div class="control-group">
                        <label for="estoqueMinimo" class="control-label"><?=$this->lang->line('prodaddprodstoqmin');?></label>
                        <div class="controls">
                            <input id="estoqueMinimo" type="text" name="estoqueMinimo" value="<?=set_value('estoqueMinimo')?>"  />
                        </div>
                    </div>

                    <div class="form-actions">
                        <div class="span12">
                            <div class="span6 offset3">
                                <button type="submit" class="btn btn-success"><i class="icon-plus icon-white"></i><?=$this->lang->line('prodaddprodadd');?></button>
                                <a href="<?=site_url('produtos')?>" id="" class="btn"><i class="icon-arrow-left"></i><?=$this->lang->line('prodaddprodvoltar');?></a>
                            </div>
                        </div>
                    </div>


                </form>
            </div>

         </div>
     </div>
</div>
<script type="text/javascript" src="<?=base_url('assets/js/jquery.min.js')?>"></script>
<script src="<?=base_url('assets/js/jquery.validate.js')?>"></script>
<script src="<?=base_url('assets/js/maskmoney.js')?>"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".money").maskMoney();

        $('#formProduto').validate({
            rules :{
                  descricao: { required: true},
                  unidade: { required: true},
                  precoCompra: { required: true},
                  precoVenda: { required: true},
                  estoque: { required: true}
            },
            messages:{
                  descricao: { required: '<?=$this->lang->line('prodaddprodobrigatorio');?>'},
                  unidade: {required: '<?=$this->lang->line('prodaddprodobrigatorio');?>'},
                  precoCompra: { required: '<?=$this->lang->line('prodaddprodobrigatorio');?>'},
                  precoVenda: { required: '<?=$this->lang->line('prodaddprodobrigatorio');?>'},
                  estoque: { required: '<?=$this->lang->line('prodaddprodobrigatorio');?>'}
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
