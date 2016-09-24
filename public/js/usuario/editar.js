var Editar = {
  
};

jQuery(document).ready(function(){
   
    jQuery("#senha").val("");
       
    jQuery("#senha").bind('keyup click', function(){
       jQuery("#gravarSenha").val("1");
    });
    
    jQuery("#super0, #super1").change(function(){
        alert("Importante!!! \n Caso esse usuário esteja logado, para que essa alteração faça efeito é necessário refazer o processo de login");
    });
    
});