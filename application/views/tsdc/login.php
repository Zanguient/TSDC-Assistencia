<?php header("Access-Control-Allow-Origin:*"); ?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title><?=$this->lang->line('nomesist');?></title><meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css')?>" />
        <link rel="stylesheet" href="<?=base_url('assets/css/bootstrap-responsive.min.css')?>" />
        <link rel="stylesheet" href="<?=base_url('assets/css/matrix-login.css')?>" />
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,700,800' rel='stylesheet' type='text/css'>
        <script src="<?=base_url('assets/js/jquery-1.10.2.min.js')?>"></script>
        <link rel="icon" href="<?=base_url('assets/img/favicon.ico')?>">
    </head>
    <body>
        <div id="loginbox">
            <div class="control-group normal_text"> <h3><img src="<?=base_url('assets/img/logo.png')?>" alt="Logo" /></h3></div>
            <?=form_open(site_url('verificarLogin'),'class="form-vertical" id="formLogin"') ?>
            <!-- <form   method="post" action="""> -->
            <?php if($this->session->flashdata('error') != null):?>
            <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <?=$this->session->flashdata('error')?>
            </div>
            <?php endif;?>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_lg"><i class="icon-user"></i></span><input id="email" name="email" type="text" placeholder="Email ou Usuário" />
                    </div>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <div class="main_input_box">
                        <span class="add-on bg_ly"><i class="icon-lock"></i></span><input name="senha" type="password" placeholder="Senha" />
                    </div>
                </div>
            </div>
            <div style="text-align: center" >
                <button class="btn btn-info btn-large">Logar</button>
            </div>
            <div class="form-actions" style="text-align: center">
                <a href="<?=site_url('/conecte')?>"><h5><span>CENTRAL DO CLIENTE</span></h5></a>
            </div>
            </form>
        </div>
    <script src="<?=base_url('assets/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('assets/js/validate.js')?>"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#email').focus();
            $("#formLogin").validate({
                rules :{
                    email: { required: true},
                    senha: { required: true}
                },
                messages:{
                    email: { required: 'Campo Requerido.'},
                    senha: {required: 'Campo Requerido.'}
                },
                submitHandler: function(form){
                    var dados = $(form).serialize();
                    $.ajax({
                        type: "POST",
                        url: "<?=site_url('verificarLogin?ajax=true')?>",
                        data: dados,
                        dataType: 'json',
                        success: function(data)
                        {
                            if(data.result == true){
                                console.log('entrou no if');
                                window.location.href = "<?=site_url()?>";
                            }
                            else{
                                $('#call-modal').trigger('click');
                            }
                        }
                    });
                    return false;
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
    <a href="#notification" id="call-modal" role="button" class="btn" data-toggle="modal" style="display: none ">notification</a>
    <div id="notification" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 id="myModalLabel"><?=$this->lang->line('nomesist');?></h4>
        </div>
        <div class="modal-body">
            <h5 style="text-align: center">Os dados de acesso estão incorretos, por favor tente novamente!</h5>
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary" data-dismiss="modal" aria-hidden="true">Fechar</button>
        </div>
    </div>
    </body>
</html>
