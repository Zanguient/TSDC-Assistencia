<a href="<?=site_url('permissoes/adicionar')?>" class="btn btn-success"><i class="icon-plus icon-white"></i><?=$this->lang->line('permpermipermiaddperm');?></a>
<?php
if(!$results){?>

        <div class="widget-box">
        <div class="widget-title">
            <span class="icon">
                <i class="icon-lock"></i>
            </span>
            <h5><?=$this->lang->line('permpermipermipermi');?></h5>

        </div>

        <div class="widget-content nopadding">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?=$this->lang->line('permpermipermiid');?></th>
                        <th><?=$this->lang->line('permpermiperminome');?></th>
                        <th><?=$this->lang->line('permpermipermidtcri');?></th>
                        <th><?=$this->lang->line('permpermipermists');?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5"><?=$this->lang->line('permpermiperminone');?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

<?php }else{


?>
<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-lock"></i>
         </span>
        <h5><?=$this->lang->line('permpermipermipermi');?></h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr>
            <th><?=$this->lang->line('permpermipermiid');?></th>
            <th><?=$this->lang->line('permpermiperminome');?></th>
            <th><?=$this->lang->line('permpermipermidtcri');?></th>
            <th><?=$this->lang->line('permpermipermists');?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            if($r->situacao == 1){$situacao = 'Ativo';}else{$situacao = 'Inativo';}
            echo '<tr>';
            echo '<td>'.$r->idPermissao.'</td>';
            echo '<td>'.$r->nome.'</td>';
            echo '<td>'.date('d/m/Y',strtotime($r->data)).'</td>';
            echo '<td>'.$situacao.'</td>';
            echo '<td>
                      <a href="'.site_url('permissoes/editar/').$r->idPermissao.'" class="btn btn-info tip-top" title="Editar Permissão"><i class="icon-pencil icon-white"></i></a>
                      <a href="#modal-excluir" role="button" data-toggle="modal" permissao="'.$r->idPermissao.'" class="btn btn-danger tip-top" title="Desativar Permissão"><i class="icon-remove icon-white"></i></a>
                  </td>';
            echo '</tr>';
        }?>
        <tr>

        </tr>
    </tbody>
</table>
</div>
</div>
<?php echo $this->pagination->create_links();}?>




<!-- Modal -->
<div id="modal-excluir" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form action="<?=site_url('permissoes/desativar') ?>" method="post" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h5 id="myModalLabel"><?=$this->lang->line('permpermipermidel');?></h5>
  </div>
  <div class="modal-body">
    <input type="hidden" id="idPermissao" name="id" value="" />
    <h5 style="text-align: center"><?=$this->lang->line('permpermipermidelmsg');?></h5>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true"><?=$this->lang->line('permpermipermicanc');?></button>
    <button class="btn btn-danger"><?=$this->lang->line('permpermipermiexc');?></button>
  </div>
  </form>
</div>


<script type="text/javascript">
$(document).ready(function(){


   $(document).on('click', 'a', function(event) {

        var permissao = $(this).attr('permissao');
        $('#idPermissao').val(permissao);

    });

});

</script>
