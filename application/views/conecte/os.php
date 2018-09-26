<?php

if(!$results){?>
	<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5><?=$this->lang->line('conecteos');?></h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th><?=$this->lang->line('conecteosnos');?></th>
            <th><?=$this->lang->line('conecteosrespo');?></th>
            <th><?=$this->lang->line('conecteosdtinicial');?></th>
            <th><?=$this->lang->line('conecteosdtfim');?></th>
            <th><?=$this->lang->line('conecteosstatus');?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td colspan="6"><?=$this->lang->line('conecteosnone');?></td>
        </tr>
    </tbody>
</table>
</div>
</div>
<?php } else{?>


<div class="widget-box">
     <div class="widget-title">
        <span class="icon">
            <i class="icon-tags"></i>
         </span>
        <h5><?=$this->lang->line('conecteos');?></h5>

     </div>

<div class="widget-content nopadding">


<table class="table table-bordered ">
    <thead>
        <tr style="backgroud-color: #2D335B">
            <th><?=$this->lang->line('conecteosnos');?></th>
            <th><?=$this->lang->line('conecteosrespo');?></th>
            <th><?=$this->lang->line('conecteosdtinicial');?></th>
            <th><?=$this->lang->line('conecteosdtfim');?></th>
            <th><?=$this->lang->line('conecteosstatus');?></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $r) {
            $dataInicial = date(('d/m/Y'),strtotime($r->dataInicial));
            $dataFinal = date(('d/m/Y'),strtotime($r->dataFinal));
            echo '<tr>';
            echo '<td>'.$r->idOs.'</td>';
            echo '<td>'.$r->nome.'</td>';
            echo '<td>'.$dataInicial.'</td>';
            echo '<td>'.$dataFinal.'</td>';
            echo '<td>'.$r->status.'</td>';
            
            
            echo '<td><a href="'.base_url().'conecte/visualizarOs/'.$r->idOs.'" class="btn tip-top" title="Ver mais detalhes"><i class="icon-eye-open"></i></a>
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