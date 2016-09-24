<?php
/**
 * Description of ArquivoHelper.
 *
 * @author edily
 */
class ArquivoHelper
{
    public static function geraNome()
    {
        $nome = md5(rand(0, 100).rand(0, 100).time());

        return $nome;
    }

    public static function detectaExtensao($nome)
    {
        $arr = explode('.', $nome);
        $ultimo = count($arr) - 1;

        return $arr[$ultimo];
    }

    public static function removeExtensao($nome)
    {
        $ext = '.'.self::detectaExtensao($nome);

        return str_replace($ext, '', $nome);
    }

    public static function resize($cur_dir, $filename, $newwidth, $output_dir, $extensao)
    {
        /*
         * $cur_dir = caminho de origem
         * $filemane = nome do arquivo
         * $newwidth = nova largura
         * $output_dir = caminho de destino, pode ser o mesmo do de origem
         * $extensao = extensao do arquivo
         */
        list($width, $height) = getimagesize($cur_dir.$filename);

        if ($width > $newwidth) {
            //SE LARGURA DO ARQUIVO FOR MAIOR QUE LARGURA ESPECIFICADA.        
            $newheight = $height * $newwidth / $width;
            $thumb = imagecreatetruecolor($newwidth, $newheight);
            imagealphablending($thumb, false);
            $erro = 1;
            if ($extensao = 'jpg' or $extensao = 'jpeg') {
                $source = @imagecreatefromjpeg($cur_dir.$filename);
                $erro = 0;
            } elseif ($extensao = 'png') {
                $source = @imagecreatefrompng($cur_dir.$filename);
                $erro = 0;
            } elseif ($extensao = 'gif') {
                $source = @imagecreatefromgif($cur_dir.$filename);
                $erro = 0;
            }
            if (!$erro) {
                imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
                $filename = "$output_dir/$filename";
                @imagejpeg($thumb, $filename);

                return 1;
            }

            return 0;
        }
    }
    
    public static function createUniqueNameRand($path, $name, $ext) 
    {
        $filename = $path . "/" . $name . "-" . date("d-m-Y_H-i-s") .
                    "-" . rand(0, 1000) . "." . $ext; 
        
        while(file_exists($filename)){
            
            $filename = $path . "/" . $name . "-" . date("d-m-Y_H-i-s") .
                    "-" . rand(0, 1000) . "." . $ext; 
            
        }            
        
        return $filename;
    }
}
