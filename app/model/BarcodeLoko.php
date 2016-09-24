<?php

/**
 * Description of BarcodeLoko
 *
 * @author Edily Cesar Medule 24/08/2014 Brasil/Brazil
 * E-mail: edilycesar@gmail.com
 * Site: www.jeitodigital.com.br 
 */

class BarcodeLoko {
    
    public $arquivo_indice_path = "/class/codigo_logo_indice.csv";
    
    private $conteudo_arq, $barra, $img_largura, $img_altura, $cor_pr, $cor_br, $img, $ponteiro = 0, 
            $padrao_ini = "bWbwBwBwb", $padrao_fim = "bWbwBwBwb",
            $padrao = array('0'=>'bwbWBwBwb','1'=>'BwbWbwbwB','2'=>'bwBWbwbwB','3'=>'BwBWbwbwb','4'=>'bwbWBwbwB','5'=>'BwbWBwbwb','6'=>'bwBWBwbwb','7'=>'bwbWbwBwB','8'=>'BwbWbwBwb','9'=>'bwBWbwBwb','A'=>'BwbwbWbwB','B'=>'bwBwbWbwB','C'=>'BwBwbWbwb','D'=>'bwbwBWbwB','E'=>'BwbwBWbwb','F'=>'bwBwBWbwb','G'=>'bwbwbWBwB','H'=>'BwbwbWBwb','I'=>'bwBwbWBwb','J'=>'bwbwBWBwb','K'=>'BwbwbwbWB','L'=>'bwBwbwbWB','M'=>'BwBwbwbWb','N'=>'bwbwBwbWB','O'=>'BwbwBwbWb','P'=>'bwBwBwbWb','Q'=>'bwbwbwBWB','R'=>'BwbwbwBWb','S'=>'bwBwbwBWb','T'=>'bwbwBwBWb','U'=>'BWbwbwbwB','V'=>'bWBwbwbwB','W'=>'BWBwbwbwb','X'=>'bWbwBwbwB','Y'=>'BWbwBwbwb','Z'=>'bWBwBwbwb')
            ;
            
    public function __construct($largura = 350, $altura = 100, $arquivo = NULL) {
        $this->arquivo_indice_path = BASE_URL . "barcodeLoko/codigo_logo_indice.csv";
        $this->img_largura = $largura;
        $this->img_altura = $altura;
        $this->arquivo = $arquivo;//se não for nulo o arquivo será gerado no disco
        
        //$this->le_arquivo();
        //$this->cria_array();
        $this->cria_imagem();
        $this->define_cores();
        $this->gera_barras_inicio();
    }
    
    public function le_arquivo() {//não usado
        $filename = getcwd().$this->arquivo_indice_path;
        if(!file_exists($filename)){
            die("O arquivo de indice não foi encontrado, verifique sua localizacao. ".$filename);
        }        
        $f = fopen($filename, "r");
        $this->conteudo_arq = fread($f, filesize($filename));
        fclose($f);
    }
    
    public function cria_array() {//não usado
        $linhas = explode("\n", $this->conteudo_arq);
        foreach ($linhas as $key => $linha) {
            $linha_arr = explode(",", $linha);
            $carac = trim($linha_arr[0]);
            $padrao = trim($linha_arr[1]);
            $this->padrao[$carac] = $padrao;
        }        
    }
    
    public function pega_padrao_carac($carac) {
        return $this->padrao[$carac];        
    }
    
    public function define_cores() {
        $this->cor_br = imagecolorallocate($this->img, 255, 255, 255);
        $this->cor_pr = imagecolorallocate($this->img, 0, 0, 0);        
    }
    
    public function cria_imagem() {
        $this->img = imagecreate($this->img_largura, $this->img_altura);
    }
    
    public function cria_arquivo() {
        
    }
    
    public function cria_barra($barra) {
        if(!empty($barra)){
            $l_p = 2; 
            $l_g = 4; 
            $x1 = $this->ponteiro;//muda
            $y1 = 0; //fixo
            $y2 = $this->img_altura; 
            
            if($barra == "B"){
               $x2 = $this->ponteiro + $l_g;//muda
               $cor = $this->cor_pr;
            }elseif($barra == "b"){
               $x2 = $this->ponteiro + $l_p;//muda
               $cor = $this->cor_pr;
            }elseif($barra == "W"){
               $x2 = $this->ponteiro + $l_g;//muda
               $cor = $this->cor_br;
            }elseif($barra == "w"){
               $x2 = $this->ponteiro + $l_p;//muda
               $cor = $this->cor_br;
            }
            
            imagefilledrectangle($this->img, $x1, $y1, $x2, $y2, $cor);
            $this->ponteiro = $x2;
        }    
    }
    
    public function gera_img() {
        $this->gera_barras_fim();        
        if(!is_null($this->arquivo) ){
            //imagegif($this->img, $this->arquivo);        
            imagepng($this->img, $this->arquivo);        
        }else{
            //header("Content-type: image/gif");
            header("Content-type: image/png");
            //imagegif($this->img);  
            imagepng($this->img);  
        }  
        imagedestroy($this->img);
    }
    
    public function gera_barras_do_caractere($carac){
        $carac = trim($carac);
        if($carac !== ""){
            $padrao = $this->pega_padrao_carac($carac);
            $this->gera_barras($padrao);        
        }
    }
    
    public function gera_barras($padrao) {
        $this->reg($padrao);
        $padrao = "w".$padrao;
        $c = strlen($padrao);
        for($i=0; $i<=$c; $i++){
            $barra = substr($padrao, $i, 1);
            $this->cria_barra($barra);
        }  
    }
    
    public function gera_barras_inicio() {        
        $this->gera_barras($this->padrao_ini);        
    }
    
    public function gera_barras_fim() {        
        $this->gera_barras($this->padrao_fim);        
    }
    
    public function reg($str){
//        $filename = "../gravar/barras_log.txt";        
//        $f = fopen($filename, "a");
//        fwrite($f, "\n".$str);
//        fclose($f);        
    }
    
    public function gerar_codigo_de_barras($cod) {
        $cod = trim($cod);
        $c = strlen($cod);
        for($i=0; $i<=$c; $i++){        
            $carac = substr($cod, $i, 1);    
            $this->gera_barras_do_caractere($carac);    
        }
        $this->gera_img();
    }
    
    //gera arquivo no disco se não existir e retorna  a url
    public function gera_arquivo($codigo) {
        
    }
}

//$cb = new BarcodeLoko(350, 100, "../gravar/barra.gif");
//$cb->gerar_codigo_de_barras($_GET['cod']);