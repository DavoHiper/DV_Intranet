$(function(){
    
    $("#cnpj_for").bind("change",function(){
        $(".titulo2").focus();
        var cnpj    =   $("#cnpj_for").val();
        var tipo    =   1;
        $.getJSON("?router=T0012/js.busca&cnpj="+cnpj+"&tipo="+tipo, function(dados){
            $(".titulo").focus();
            $.each(dados, function(i, item){
                if (i==="RAZ"){
                    $("#raz_social").val(item);
                }else if (i    ===  "COD"){
                    $("#rms_codigo").val(item);
                }
            });
        });
    });
    
    $("#rms_codigo").live("change",function(){
        $(".titulo2").focus();
        var cod     =   $("#rms_codigo").val();
        var tipo    =   2;
        $.getJSON("?router=T0012/js.busca&cod="+cod+"&tipo="+tipo, function(dados){
            $(".titulo").focus();
            $.each(dados, function(i, item){
                if (i==="RAZ"){
                    $("#raz_social").val(item);
                }else if (i==="CGC"){
                    $("#cnpj_for").val(item);
                }
            });
        });
    });    
    
    $(".loja").live("blur",function(){
        var $this   =   $(this);
        var cont    =   $this.parents(".linha").find(".numerador").val();
        
        if ((cont <=  19) && ($(".loja").val() != ""))
        {
            var cod     =   $("#rms_codigo").val();
            var titulo  =   $this.parents(".linha").find(".titulo2").val();
            var serie   =   $this.parents(".linha").find(".serie").val();
            var desd    =   $this.parents(".linha").find(".desd").val();
            var tipo    =   3;
            var loja    =   $this.parents(".linha").find(".loja").val();
            
            $.getJSON("?router=T0012/js.busca&cod="+cod+"&titulo="+titulo+"&desd="+desd+"&serie="+serie+"&tipo="+tipo+"&loja="+loja, function(dados){
                
                $.each(dados, function(i, item){
                    if  (i ===  "LOJ"){
                        $this.parents(".linha").find(".loja").val(loja);
                    }else if (i ===  "AGE"){
                        $this.parents(".linha").find(".agenda").val(item);
                    }else if (i ===  "DSA"){
                        $this.parents(".linha").find(".desc").val(item);
                    }else if (i ===  "DAG"){
                        $this.parents(".linha").find(".dt_agenda").val(item);
                    }else if (i ===  "DVE"){
                        $this.parents(".linha").find(".dt_vencto").val(item);
                    }else if (i ===  "BRT"){
                        $this.parents(".linha").find(".bruto").val("R$ "+item);
                    }else if (i ===  "LIQ"){
                        $this.parents(".linha").find(".liquido").val("R$ "+item);
                        var total = $("#total").val();
                        //Remove 'R$ '
                        total = total.substring(3);
                        total = parseFloat(total);
                        if(isNaN(total))
                        {
                            total = 0;
                        }
                        total += parseFloat(item);
                        $("#total").val("R$ "+total);
                    }
                })

            })
            
            $.post("?router=T0012/js.retornaLoja", function(combo){
                
            
            //Numerador de linhas
            cont++;
            var input   =   '<tr class= "linha">';
                input  +=   '<td><input style="margin-left:1px;" type="text" name="titulo[]"    size="3"  maxlength="10"                             class="titulo2"     /></td>';
                input  +=   '<td><input style="margin-left:5px;" type="text" name="serie[]"     size="3"  maxlength="4"                              class="serie"       /></td>';
                input  +=   '<td><input style="margin-left:5px;" type="text" name="desd[]"      size="3"  maxlength="2"                              class="desd"        /></td>';
                input  +=   '<td>'+combo+'</td>';
                input  +=   '<td><input style="margin-left:20px;" type="text" name="agenda[]"    size="3"  maxlength="3"                              class="agenda"  readonly    />\n\
                                 <input style="margin-left:10px;" type="text" name="desc[]"      size="63" maxlength="60"                             class="desc"      readonly  />                            \n\
                            <br><br>\n\
                            <input style="margin-left:15px; text-align: right;" type="text" name="dt_agenda[]" class="dt_agenda" size="13"  maxlength="10" style="text-align: right;" readonly/>    \n\
                            <input style="margin-left:10px; text-align: right;" type="text" name="dt_vencto[]" class="dt_vencto" size="13"  maxlength="10"  readonly/>\n\
                            <input style="margin-left:10px; text-align: right;" type="text" name="bruto[]"     class="bruto"     size="13"  maxlength="10"  readonly/>\n\
                            <input style="margin-left:10px; text-align: right;" type="text" name="liquido[]"   class="liquido"   size="13"  maxlength="10"  readonly/>  </td>\n\
';
                input  +=   '<td></td>';
                input  +=   '<td><input style="margin-left:5px;" type="hidden" name="numerador"     value='+(cont)+' class="numerador"/></td>';
                input  +=   '</tr>';
                input  +=   '<tr>';
                input  +=   '<td> </td>';
                input  +=   '</tr>';
            $(".form-inpu-tab").append(input);
            $(".titulo2").focus();
        });
            //Soma Liquido para campo Total
            
        }
//        else
//        {
//            alert("acima de 20");
//        }        
        
    });
    
    
    $(".loja").live("focus",function(){
        var $this   =   $(this);
        var cont    =   $this.parents("tr").find(".numerador").val();

    });    
                
});