function confirmButtonProfilePenjual(s){
	var returnValue = 0;
	if (confirm("Yakin ingin mengubah data?")) {
		returnValue = 1;
		document.getElementById("s").value = returnValue;
	}
	if (returnValue==0) {
			//ubah required form menjadi hilang
			document.getElementById("namadepan_penjual").required = false;
			document.getElementById("email_penjual").required = false;
			document.getElementById("hp_penjual").required = false;
			document.getElementById("dompet_penjual").required = false;
			document.getElementById("password_penjual").required = false;
			document.getElementById("repeat_password_penjual").required = false;
			document.getElementById("s").value = returnValue;
		}
		
	}

