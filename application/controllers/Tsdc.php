<?php 

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Tsdc extends MY_Controller
{
    /**
     * author: Ramon Silva
     * email: silva018-mg@yahoo.com.br.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('tsdc_model');

    }
    public function index()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('/login');
        }
      

        $this->data['ordens']                   = $this->tsdc_model->getOsAbertas();
        $this->data['ordens_orcamento']         = $this->tsdc_model->getOsOrcamentos();
        $this->data['produtos']                 = $this->tsdc_model->getProdutosMinimo();
        $this->data['os']                       = $this->tsdc_model->getOsEstatisticas();
        $this->data['estatisticas_financeiro']  = $this->tsdc_model->getEstatisticasFinanceiro();
        $this->data['menuPainel']               = 'Painel';
        $this->data['view']                     = 'tsdc/painel';
        $this->load->view('tema/topo', $this->data);
    }
    public function minhaConta()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('tsdc/login');
        }

        $this->data['usuario'] = $this->tsdc_model->getById($this->session->userdata('id'));
        $this->data['view'] = 'tsdc/minhaConta';
        $this->load->view('tema/topo',  $this->data);
    }
    public function alterarSenha()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('tsdc/login');
        }

        $oldSenha = $this->input->post('oldSenha');
        $senha = $this->input->post('novaSenha');
        $result = $this->tsdc_model->alterarSenha($senha, $oldSenha, $this->session->userdata('id'));
        if ($result) {
            $this->session->set_flashdata('success', 'Senha Alterada com sucesso!');
            redirect(base_url().'index.php/tsdc/minhaConta');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar a senha!');
            redirect(base_url().'index.php/tsdc/minhaConta');
        }
    }
    public function pesquisar()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('tsdc/login');
        }

        $termo = $this->input->get('termo');

        $data['results'] = $this->tsdc_model->pesquisar($termo);
        $this->data['produtos'] = $data['results']['produtos'];
        $this->data['servicos'] = $data['results']['servicos'];
        $this->data['os'] = $data['results']['os'];
        $this->data['clientes'] = $data['results']['clientes'];
        $this->data['view'] = 'tsdc/pesquisa';
        $this->load->view('tema/topo',  $this->data);
    }
    public function login()
    {
        $this->load->helper('form');
        $this->load->view('tsdc/login');
    }
    public function sair()
    {
        $this->session->sess_destroy();
        unset($_COOKIE);
        redirect('login');
    }
    public function verificarLogin()
    {
        // carrega bibliotecas do CI
        $this->load->library('form_validation');

        // configurações do formulario de login
        // torna obrigatório preencher email e senha.
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('senha', 'Senha', 'required');

        $ajax = $this->input->get('ajax');
        
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');

        $usuario = $this->tsdc_model->getSenhaUsuario($email);
        if ($this->form_validation->run() == false) {
            if ($ajax == 'true') {
                $json = array('result' => false);
                $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                echo json_encode($json);
            } else {
                $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                redirect('login');
            }
        } else {
            if($usuario->num_rows() > 0){ 
                $usuario = $usuario->result();
                if (password_verify($senha, $usuario[0]->senha)) {
                    $this->db->where('email', $usuario[0]->email);
                    $this->db->limit(1);
                    $usuario = $this->db->get('usuarios')->row();
                    $dados = array(
                        'session_id' => session_id(),
                        'nome' => $usuario->nome,
                        'id' => $usuario->idUsuarios,
                        'permissao' => $usuario->permissoes_id,
                        'logado' => true, );
                    $this->session->set_userdata($dados);

                    if ($ajax == 'true') {
                        $json = array('result' => true);
                        echo json_encode($json);
                    } else {
                        $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                        redirect('');
                    }
                }else{
                    if ($ajax == 'true') {
                    $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                    $json = array('result' => false);
                    echo json_encode($json);
                    } else {
                        $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                        redirect($this->login);
                    }
                }
            }else {
                if ($ajax == 'true') {
                    $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                    $json = array('result' => false);
                    echo json_encode($json);
                } else {
                    $this->session->set_flashdata('error', 'Os dados de acesso estão incorretos.');
                    redirect($this->login);
                }
            }
        }
    }
    public function backup()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('tsdc/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cBackup')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para efetuar backup.');
            redirect(base_url());
        }

        $this->load->dbutil();
        $prefs = array(
                'format' => 'zip',
                'filename' => 'backup'.date('d-m-Y').'.sql',
              );

        $backup = &$this->dbutil->backup($prefs);

        $this->load->helper('file');
        write_file(base_url().'backup/backup.zip', $backup);

        $this->load->helper('download');
        force_download('backup'.date('d-m-Y H:m:s').'.zip', $backup);
    }
    public function emitente()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('tsdc/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $data['menuConfiguracoes'] = 'Configuracoes';
        $data['dados'] = $this->tsdc_model->getEmitente();
        $data['view'] = 'tsdc/emitente';
        $this->load->view('tema/topo', $data);
        $this->load->view('tema/rodape');
    }
    public function do_upload()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('tsdc/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('upload');

        $image_upload_folder = FCPATH.'assets/uploads';

        if (!file_exists($image_upload_folder)) {
            mkdir($image_upload_folder, DIR_WRITE_MODE, true);
        }

        $this->upload_config = array(
            'upload_path' => $image_upload_folder,
            'allowed_types' => 'png|jpg|jpeg|bmp',
            'max_size' => 2048,
            'remove_space' => true,
            'encrypt_name' => true,
        );

        $this->upload->initialize($this->upload_config);

        if (!$this->upload->do_upload()) {
            $upload_error = $this->upload->display_errors();
            print_r($upload_error);
            exit();
        } else {
            $file_info = array($this->upload->data());

            return $file_info[0]['file_name'];
        }
    }
    public function cadastrarEmitente()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('index.php/tsdc/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Razão Social', 'required');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
        $this->form_validation->set_rules('ie', 'IE');
        $this->form_validation->set_rules('logradouro', 'Logradouro', 'required');
        $this->form_validation->set_rules('numero', 'Número', 'required');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('uf', 'UF', 'required');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/tsdc/emitente');
        } else {
            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $image = $this->do_upload();
            $logo = base_url().'assets/uploads/'.$image;

            $retorno = $this->tsdc_model->addEmitente($nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email, $logo);
            if ($retorno) {
                $this->session->set_flashdata('success', 'As informações foram inseridas com sucesso.');
                redirect(base_url().'index.php/tsdc/emitente');
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar inserir as informações.');
                redirect(base_url().'index.php/tsdc/emitente');
            }
        }
    }
    public function editarEmitente()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('index.php/tsdc/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Razão Social', 'required');
        $this->form_validation->set_rules('cnpj', 'CNPJ', 'required');
        $this->form_validation->set_rules('ie', 'IE');
        $this->form_validation->set_rules('logradouro', 'Logradouro', 'required');
        $this->form_validation->set_rules('numero', 'Número', 'required');
        $this->form_validation->set_rules('bairro', 'Bairro', 'required');
        $this->form_validation->set_rules('cidade', 'Cidade', 'required');
        $this->form_validation->set_rules('uf', 'UF', 'required');
        $this->form_validation->set_rules('telefone', 'Telefone', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('error', 'Campos obrigatórios não foram preenchidos.');
            redirect(base_url().'index.php/tsdc/emitente');
        } else {
            $nome = $this->input->post('nome');
            $cnpj = $this->input->post('cnpj');
            $ie = $this->input->post('ie');
            $logradouro = $this->input->post('logradouro');
            $numero = $this->input->post('numero');
            $bairro = $this->input->post('bairro');
            $cidade = $this->input->post('cidade');
            $uf = $this->input->post('uf');
            $telefone = $this->input->post('telefone');
            $email = $this->input->post('email');
            $id = $this->input->post('id');

            $retorno = $this->tsdc_model->editEmitente($id, $nome, $cnpj, $ie, $logradouro, $numero, $bairro, $cidade, $uf, $telefone, $email);
            if ($retorno) {
                $this->session->set_flashdata('success', 'As informações foram alteradas com sucesso.');
                redirect(base_url().'index.php/tsdc/emitente');
            } else {
                $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar as informações.');
                redirect(base_url().'index.php/tsdc/emitente');
            }
        }
    }
    public function editarLogo()
    {
        if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
            redirect('index.php/tsdc/login');
        }

        if (!$this->permission->checkPermission($this->session->userdata('permissao'), 'cEmitente')) {
            $this->session->set_flashdata('error', 'Você não tem permissão para configurar emitente.');
            redirect(base_url());
        }

        $id = $this->input->post('id');
        if ($id == null || !is_numeric($id)) {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar a logomarca.');
            redirect(base_url().'index.php/tsdc/emitente');
        }
        $this->load->helper('file');
        delete_files(FCPATH.'assets/uploads/');

        $image = $this->do_upload();
        $logo = base_url().'assets/uploads/'.$image;

        $retorno = $this->tsdc_model->editLogo($id, $logo);
        if ($retorno) {
            $this->session->set_flashdata('success', 'As informações foram alteradas com sucesso.');
            redirect(base_url().'index.php/tsdc/emitente');
        } else {
            $this->session->set_flashdata('error', 'Ocorreu um erro ao tentar alterar as informações.');
            redirect(base_url().'index.php/tsdc/emitente');
        }
    }
    function os_aberta(){
        // if ((!$this->session->userdata('session_id')) || (!$this->session->userdata('logado'))) {
        //     redirect('index.php/tsdc/login');
        //     echo json_encode(0);
        // }
        $this->load->model('os_model');
         // "draw": 1,
         //  "recordsTotal": 57,
         //  "recordsFiltered": 57,
        // get($table, $fields, $where = '', $perpage = 0, $start = 0, $one = false, $array = 'array')
        // search[value]:tiago
        $post_dados = $this->input->post();
        if ($post_dados['search']['value']) {
            $where_form = "AND clientes.nomeCliente LIKE '%{$post_dados['search']['value']}%'" ;
        }else{
            $where_form = '';
        }
        $where = sprintf('os.status = "%s" %s', $post_dados['status_os'], $where_form);
        $perpage = $post_dados['length'];
        $start = $post_dados['start'];
        $campos = 'os.idOs, os.dataFinal, os.dataInicial, clientes.nomeCliente';
        $order_by = array('coluna' => $post_dados['columns'][$post_dados['order'][0]['column']]['data'], 'order' => $post_dados['order'][0]['dir']);
        
        $oss = $this->os_model->get('os', $campos, $where, $perpage, $start, $one = false, $array = 'array',  $order_by);

        // // $oss = $this->tsdc_model->getOsAbertas(); 
        // var_dump($_POST);
        if (is_array($oss)) {
            $new_oss = array();
            foreach ($oss as $idx => $os) {
                $new_oss[] = [
                "idOs" => $os->idOs, 
                "dataInicial" => date('d/m/Y' ,strtotime($os->dataInicial)), 
                "dataFinal" => date('d/m/Y' ,strtotime($os->dataFinal)), 
                "nomeCliente" => $os->nomeCliente, 
                "botao" => sprintf("<a href='%s' class='btn'> <i class='icon-eye-open' ></i> </a><a style='margin-right: 1px' href='%s' class='btn btn-info tip-top' data-original-title='Editar OS'><i class='icon-pencil icon-white'></i></a> ", site_url('os/visualizar/'.$os->idOs), site_url('os/editar/'.$os->idOs)) ];
            }
            $total_rows = count($new_oss);
            $resultado = ['data' => $new_oss, "recordsTotal" => $total_rows, "recordsFiltered" => $total_rows];
            echo json_encode($resultado);
        }else{
            echo json_encode(0);
            
        }
    }
}
