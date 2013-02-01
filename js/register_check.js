// проверяваме името
function checkIme() {
	var ime = document.register.ime.value;
	
	if(ime.length > 1)
	{
		if(isNaN(ime)) {
			$("#imeMsg").hide().html('Valid name&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
		else {
			$("#imeMsg").hide().html('<font color="red">Invalid name!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
	}
	else {
		$("#imeMsg").hide().html('<font color="red">Must contain more than <strong>1</strong> letter!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
} 
// проверява email
function checkEmail() 
{
   var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
   var address = document.register.email.value;
   if(reg.test(address) == false) 
   {
     	$("#emailMsg").hide().html('<font color="red">Write valid e-mail!</font>').fadeIn();
   }
   else
   {
		$("#emailMsg").hide().html('Valid e-mail&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
   }
}
// проверяваме презимето
function checkPrezime() {
	var prezime = document.register.prezime.value;
	
	if(prezime.length > 2)
	{
		if(isNaN(prezime)) {
			$("#prezimeMsg").hide().html('Valid surname&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
		else {
			$("#prezimeMsg").hide().html('<font color="red">Invalid surname!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
	}
	else {
		$("#prezimeMsg").hide().html('<font color="red">Must contain more than <strong>2</strong> letters!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверяваме фамилията
function checkFamiliq() {
	var familiq = document.register.familiq.value;
	
	if(familiq.length > 2)
	{
		if(isNaN(familiq)) {
			$("#familiqMsg").hide().html('Valid last name&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
		else {
			$("#familiqMsg").hide().html('<font color="red">Invalid last name!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
	}
	else {
		$("#familiqMsg").hide().html('<font color="red">Must contain more than <strong>2</strong> letters!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверяваме З.Н.П.З.
function checkZnpz() {
	var znpz = document.register.znpz.value;
	
	if(znpz.length > 2) 
	{
		if(isNaN(znpz)) {
			$("#znpzMsg").hide().html('<font color="red">Invalid Required hours!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
		else {
			$("#znpzMsg").hide().html('Valid Required hours&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
	}
	else {
		$("#znpzMsg").hide().html('<font color="red">Must contain more than <strong>2</strong> numbers!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверяваме password1
function checkPassword() {
	var password = document.register.password1.value;
	
	if(password.length > 3) {
		$("#passwordMsg").hide().html('Valid password&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
		document.register.submit.disabled = false;
	}
	else {
		$("#passwordMsg").hide().html('<font color="red">Password must contain more than <strong>3</strong> symbols!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверяваме дали паролите съвпадат
function checkPasswords() {
	var password1 = document.register.password1.value;
	var password2 = document.register.password2.value;
				
	if(password1.length > 3 && password2.length > 3) {
		if(password1 == password2) {
			$("#passwords").hide().html('The passwords match&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
		else {
			$("#passwords").hide().html('<font color="red">The passwords does not match!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
	}
	else {
		$("#passwords").hide().html('<br />').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверява дали е избран клас за ученика
function checkKlas() {
	var klas = document.register.classid.value;
	
	if(klas.length > 0 && klas != "----------") {
		$("#klasMsg").hide().html('Selected class&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
		document.register.submit.disabled = false;
	}
	else {
		$("#klasMsg").hide().html('<font color="red">Select class!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверява ЕГН
function checkEgn() {
	var egn = document.register.egn.value;
	
	if(egn.length == 10) {
		if(isNaN(egn)) { 
			$("#egnMsg").hide().html('<font color="red">Invalid UCC!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
		else { 
			$("#egnMsg").hide().html('Valid UCC&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
	}
	else {
		$("#egnMsg").hide().html('<font color="red">Check the length of the UCC!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверява дали са избрани класове
function checkKlasove() {
	var klas = document.register.klas;
	var klas_choices = 0;
	for(i = 0; i < klas.length; i++){
		klas_choices = klas_choices + 1;
		if(klas[i].checked == false) {
			klas_choices = klas_choices - 1;
		}
	}
	if(klas_choices > 0)
	{
		$("#klasoveMsg").hide().html('Selected classes&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
		document.register.submit.disabled = false;
	}
	else {
		$("#klasoveMsg").hide().html('<font color="red">Select classes!</font>').fadeIn();
		document.register.submit.disabled = true;
		
	}
}
// проверява телефона
function checkTelefon() {
	var telefon = document.register.telefon.value;
	
	if(telefon.length > 3) {
		if(isNaN(telefon)) {
			$("#telefonMsg").hide().html('<font color="red">Invalid telephone!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
		else {
			$("#telefonMsg").hide().html('Valid telephone&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
	}
	else {
		$("#telefonMsg").hide().html('<font color="red">Telephone should contain more than <b>3</b> numbers!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверява адреса
function checkMestojiveene() {
	var mesto = document.register.mestojiveene.value;
	
	if(mesto.length > 4)
	{
		if(isNaN(mesto)) {
			$("#mestoMsg").hide().html('Valid address&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
			document.register.submit.disabled = false;
		}
		else {
			$("#mestoMsg").hide().html('<font color="red">Invalid address!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
	}
	else {
		$("#mestoMsg").hide().html('<font color="red">The address should contain more than <b>4</b> symbols!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
}
// проверява номера на ученика
function checkNumber() {
	var number = document.register.number.value;
	
	if(number.length == 0)
	{
		$("#numberMsg").hide().html('<font color="red">Invalid number!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
	else {
		if(number.length > 2)
		{
			$("#numberMsg").hide().html('<font color="red">The number should not be more than <b>2</b> numbers!</font>').fadeIn();
			document.register.submit.disabled = true;
		}
		else {
			if(isNaN(number))
			{
				$("#numberMsg").hide().html('<font color="red">The number should contain only numbers!</font>').fadeIn();
				document.register.submit.disabled = true;
			}
			else {
				$("#numberMsg").hide().html('Valid number&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
				document.register.submit.disabled = false;
			}
		}
	}
}
// проверява дали са избрани предмети
function checkPredmet() {
	var predmet = document.register.predmet;
	var predmet_choices = 0;
	for(i = 0; i < predmet.length; i++){
		predmet_choices = predmet_choices + 1;
		if(predmet[i].checked == false) {
			predmet_choices = predmet_choices - 1;
		}
	}
	if(predmet_choices > 0)
	{
		$("#predmetMsg").hide().html('Selected subjects&nbsp;<img src="images/tick.gif" align="absmiddle">').fadeIn();
		document.register.submit.disabled = false;
	}
	else {
		$("#predmetMsg").hide().html('<font color="red">Select subjects!</font>').fadeIn();
		document.register.submit.disabled = true;
		
	}
}
// проверява съобщението
function checkMessage() {
	var message = document.register.message.value;
	
	if(message.length <= 10)
	{
		$("#messageMsg").hide().html('<font color="red">Should contain more than <b>10</b> symbols!</font>').fadeIn();
		document.register.submit.disabled = true;
	}
	else {
		$("#messageMsg").html('<br />');
		document.register.submit.disabled = false;
	}
}