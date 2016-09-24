var CarroEditar = {
  
  secretariaForcar: function(){      
      var secretariaId = jQuery("#secretariaForcar").val();
      if(secretariaId !== 0){          
          jQuery("#idS").val(secretariaId); 
          jQuery("#idS").change(function(){
             if(jQuery(this).val() !== secretariaId){
                 alert("Você não tem permissão para alterar esse campo");
                jQuery("#idS").val(secretariaId); 
             } 
          });
      }      
  }
};

jQuery(document).ready(function(){
   
   CarroEditar.secretariaForcar(); 
   
});