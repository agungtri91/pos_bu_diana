

function nilai_currency(elem){
	var elem_id = elem.id;
	var elem = '#'+elem.id;
	var elem_val_curr = $(elem).val();
	var elem_val_curr_no_rupiah = remove_rupiah(elem_val_curr);
	var elem_val_curr_no_currency = elem_val_curr_no_rupiah.toString().replace(/[^0-9\.]+/g, "");

	var elem_str = elem_id.toString();
	var elem_no_cur = elem_str.replace(/_currency/g,'');

	var elem_val_currency = format_rupiah(elem_val_curr);
	$(elem).val(elem_val_currency);
	$('#'+elem_no_cur).val(elem_val_curr_no_currency);
}

function nilai_currency_2(elem){
	var elem_id = elem.id;
	var elem = '#'+elem.id;
	var elem_val_curr = $(elem).val()||0;
	// var elem_val_curr_no_rupiah = remove_rupiah(elem_val_curr);
	var elem_val_curr_str = elem_val_curr.toString();
	var elem_val_curr_no_currency = remove_currency_2(elem_val_curr_str)

	var elem_str = elem_id.toString();
	var elem_no_cur = elem_str.replace(/_currency/g,'');

	var elem_val_currency = toRp(elem_val_curr);

	console.log(elem_val_currency);
	// $(elem).val(elem_val_currency);
	// $('#'+elem_no_cur).val(elem_val_curr_no_currency);
}

function nilai_currency_3(elem){
	var elem_id = elem.id;
	var elem = '#'+elem.id;
	var elem_val_curr = $(elem).val();
	var elem_val_curr_no_rupiah = remove_rupiah(elem_val_curr);
	var elem_val_curr_no_currency = elem_val_curr_no_rupiah.toString().replace(/[^0-9\.]+/g, "");

	var elem_str = elem_id.toString();
	var elem_no_cur = elem_str.replace(/_currency/g,'');

	var elem_val_currency = format_rupiah(elem_val_curr);
	$(elem).val(elem_val_currency);
	$('#'+elem_no_cur).val(elem_val_currency);
	console.log(elem_val_currency);
}

function number_currency(elem){
	var elem_id = elem.id;
	var elem = '#'+elem.id;
	var elem_val_curr = $(elem).val();
	var elem_str = elem_id.toString();

	var elem_val_no_curr = elem_val_curr.toString()||0;
	var elem_val_no_curr = elem_val_no_curr.replace("." ,"");
	var elem_no_cur_str = elem_str.replace(/_currency/g,'');

	$('#'+elem_id).val(toRp(elem_val_no_curr));
	$('#'+elem_no_cur_str).val(elem_val_no_curr);
}

function pembulatan(num){
  var num_str = num.toString();
  var tiga_akhir = num_str.substr(num_str.length - 2);
  if (tiga_akhir !== '00') {
    var pembulatan = 100 - parseInt(tiga_akhir);
    num_str = parseInt(num_str) + parseInt(pembulatan);
  }
  return num_str;
}

function remove_currency(num){
  var str = num.toString().replace(/[^0-9\.]+/g, "");
  return str;
}

function remove_currency_2(num){
  var str = num.toString().replace(/[^0-9\,]+/g, "");
  return str;
}

function remove_rupiah(num){
  var str = num.toString().replace("Rp. ", "");
  return str;
}


var format_rupiah = function(num){
    var str = num.toString().replace("Rp. ", ""), parts = false, output = [], i = 1, formatted = null;
    if(str.indexOf(".") > 0) {
      parts = str.split(".");
      str = parts[0];
    }
    str = str.split("").reverse();
    for(var j = 0, len = str.length; j < len; j++) {
      if(str[j] != ",") {
        output.push(str[j]);
        if(i%3 == 0 && j < (len - 1)) {
          output.push(",");
        }
        i++;
      }
    }

    formatted = output.reverse().join("");
      return("Rp. " + formatted + ((parts) ? "." + parts[1].substr(0, 2) : ""));
};


function toRp(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return rev2.split('').reverse().join('');
}

function confirm_delete(id,control){
	var a = confirm("Anda yakin ingin menghapus record ini ?");
	if(a==true){
		window.location.href = control+id;
	}
}
function confirm_delete_2(id,id2,control){
	var a = confirm("Anda yakin ingin menghapus record ini ?");
	if(a==true){
		window.location.href = control+id+'&branch_id='+id2;
	}
}

function confirm_delete_3(id,id2,control,control2){
	var a = confirm("Anda yakin ingin menghapus record ini ?");
	if(a==true){
		window.location.href = control+id+control2+id2;
	}
}

function confirm_payment(id,control){
	var a = confirm("Anda yakin ingin membayar pembelian ini ?");
	if(a==true){
		window.location.href = control+id;
	}
}

function confirm_onprogress(id,control){
	var a = confirm("Anda yakin ingin memproses data ini?");
	if(a==true){
		window.location.href = control+id;
	}
}

function confirm_done(id,control){

	var a = confirm("Apakah sudah terkonfirmasi ?");
	if(a==true){
		window.location.href = control+id;
	}
}
function confirm_transaction(id,control,nopol){
	var a = confirm("Anda yakin ingin mengkonfirmasi kedatangan truck dengan nopol "+nopol);
	if(a==true){
		window.location.href = control+id;
	}
}
function confirm_act(id,control){
	var a = confirm("Anda yakin ingin mengaktifkan data ini ?");
	if(a==true){
		window.location.href = control+id;
	}
}

function confirm_approved(id,control){
	var a = confirm("Anda yakin ingin approve data ini ?");
	if(a==true){
		window.location.href = control+id;
	}
}

function confirm_not_approved(id,control){
	var a = confirm("Anda yakin ingin reject data ini ?");
	if(a==true){
		window.location.href = control+id;
	}
}


function toRp(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return rev2.split('').reverse().join('');
}
