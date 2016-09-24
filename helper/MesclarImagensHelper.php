<?php
/**
 * Description of ArquivoHelper.
 *
 * @author edily
 */
class MesclarImagens
{
    public function mesclarPng($pathImg1, $pathImg2)
    {
        $dst_im = imagecreatefrompng($pathImg1);
        $src_im = imagecreatefrompng($pathImg2);

        $w = (int) imagesx($dst_im) / 3;
        $h = (int) imagesY($dst_im) / 3;

        imagecopymerge(
               $dst_im,
               $src_im,
               0,
               0,
               0,
               0,
               $w,
               $h,
               100);

        imagepng($dst_im);
        imagedestroy($dst_im);
//             int imagecopymerge ( resource $dst_im , resource $src_im , int $dst_x , 
//               int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h , int $pct )

//               Copia parte de src_im em dst_im começando nas coordenadas src_x, 
//               src_y com a largura de src_w e altura de src_h. 
//               A porção definida será copiada nas coordenadas x,y, dst_x e dst_y. 
//               As duas imagens serão combinadas de acordo com pct o qual pode variar 
//               de 0 a 100. Quando pct = 0, não haverá modificação, quando 100 esta 
//               função funciona de modo identico a imagecopy() para imagens de paleta, 
//               enquanto implemente transparencia alpha para imagens true colour. 
    }
}
