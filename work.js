        
		//Cria-se uma store da combo. Com muitos valores(records).
		var store = field.getStore();
		
		//Para mostrar tudo.
        store.clearFilter();
 
		//Encontra a combo do typ_fisc
        var typ_fisc = field.up("form").getForm().findField("typ_fisc");
		
		//Na combo typ_fisc seleciona o valor do record que tem o typ_fisc selecionado actualmente.
        var record = typ_fisc.store.findRecord("typ_fisc", typ_fisc.getValue() );

		Remove this useless assignment to local variable "record"   
a month ago   L238   
Bug  Major  Open   Paulo Miguel MONIZ   15min effort Comment
 cert, cwe, unused  
Remove the declaration of the unused 'record' variable.   
a month ago   L238   
Code Smell  Major  Open   Paulo Miguel MONIZ   5min effort Comment
 unused  
		
		//Se o record da store tem cumpre esta regra é adicionado à store se não é removido.
        store.filterBy(function(record){
            if(record.get('cd_pays_emet_val') === typ_fisc.getValue() ){
                return true;
            }else{
				return false;
			}
        });
 
		//Preecher a label.
        var record2 = field.store.findRecord("cd_fisc", field.getValue());       
		if(record2 !== null){
            field.up("form").getForm().findField("lib_cd_fisc").setValue(record2.get("lib_cd_fisc"));
        }else{
            field.up("form").getForm().findField("lib_cd_fisc").setValue("");
        }
    }
 
