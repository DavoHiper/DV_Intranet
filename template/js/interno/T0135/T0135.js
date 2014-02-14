$(function(){
   
$(".exclui").live("click", function(){
    
        var $this           =   $(this);   
        var codigoUsuario   =   $this.parents("tr.dados").find(".codigo").text();
        
        
        
        $("#dialog-mensagem-usuarioEms").html("<p style='padding-top:10px;'>Essa ação Excluirá o Usuário <br><br>"+codigoUsuario+" <br><br> Tem certeza que deseja fazer isso ?</p>");
        $("#dialog-mensagem-usuarioEms").dialog
        ({
            resizable: false,
            height:180,
            width:250,
            modal: true,
            draggable: false,
            title:  "Mensagem",
            buttons:
            {
                    "Ok": function(){
                      
                        $.post("?router=T0135/js.excluirUsuario", {cod:codigoUsuario}, function(dados){
                            
                              $this.parents("tr.dados").remove();
                            
                             
                        });
                           
                           $(this).dialog("close");
                
            } 
                    ,
                   Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        });  
        });
        
$(".excluiFaixa").live("click", function(){
    
        var $this           =   $(this);   
        var codigoUsuario   =   $(".codigo").val();
        var codigoFaixa     =   $this.parents("tr.dados").find(".codigoFaixa").text();
        var nomeFaixa     =   $this.parents("tr.dados").find(".nomeFaixa").text();
        
        
        
        $("#dialog-mensagem-faixaCobranca").html("<p style='padding-top:10px;'>Essa ação Excluirá a faixa <br><br>"+nomeFaixa+" <br><br> Tem certeza que deseja fazer isso ?</p>");
        $("#dialog-mensagem-faixaCobranca").dialog
        ({
            resizable: false,
            height:180,
            width:250,
            modal: true,
            draggable: false,
            title:  "Mensagem",
            buttons:
            {
                    "Ok": function(){
                      
                        $.post("?router=T0135/js.excluirUsuario", {codFaixa:codigoFaixa, cod:codigoUsuario}, function(dados){
                            
                              $this.parents("tr.dados").remove();
                            
                             
                        });
                           
                           $(this).dialog("close");
                
            } 
                    ,
                   Cancelar: function(){
                        $(this).dialog("close");
                    }
            }
        });  
        });
    
});
    

