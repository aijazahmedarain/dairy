		// валидира преди да изтриеме нещо
		function validate_erase(thing) 
		{
			if(confirm("Are you sure you want to delete " + thing + " ?"))
			{
				return true;
			}
			else {
				return false;
			}
		}
		// зарежда предметите на класовете
		function load_subjects()
		{
			$("#subjects").html('<div><br /></div><img src="images/loader.gif"> <b>Loading...</b><div><br /></div>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var classid = document.getElementById("classid").value;
			var url = "scripts/predmet_class.php?classid=" + classid;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#subjects").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		//проверка за username
		function check_username() 
		{
			$("#status").html('<img src="images/loader.gif"> <b>Loading....</b>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var username = document.getElementById("username").value;
			var url = "scripts/check_register.php?username=" + username;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged() 
			{
				if(xmlhttp.readyState == 4)
				{
					$("#status").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		// регистрира ученик
		function register_student()
		{
			$("#message").html('<img src="images/loader.gif"> <b>Loading....</b>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}

			var ime = $("#ime").val();
			var prezime = $("#prezime").val();
			var familiq = $("#familiq").val();
			var egn = document.register.egn.value;
			var telefon = $("#telefon").val();
			var mestojiveene = $("#mestojiveene").val();
			var classid = $("#classid").val();
			var number = $("#number").val();
			var username = $("#username").val();
			var password1 = $("#password1").val();
			var password2 = $("#password2").val();
			var email = $("#email").val();
			
			var url = 'scripts/register_student.php?ime=' + ime + '&familiq=' + familiq + '&prezime=' + prezime + '&telefon=' + telefon + '&mestojiveene=' + mestojiveene + '&classid=' + classid + '&number=' +number+ '&username='+ username + '&password1=' + password1 + '&password2='+password2 + '&email=' + email + '&egn=' + egn;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#message").hide().html(xmlhttp.responseText).fadeIn();
					if(xmlhttp.responseText == '<div align="center"><div id="success">Succcessfully registered student!</div></div>')
					{
						$("#mestoMsg").html('<br/ >'); document.getElementById("mestojiveene").value = ''
						$("#imeMsg").html('<br/ >'); document.getElementById("ime").value = '';
						$("#prezimeMsg").html('<br/ >'); document.getElementById("prezime").value = '';
						$("#familiqMsg").html('<br/ >'); document.getElementById("familiq").value = '';
						$("#numberMsg").html('<br/ >'); document.getElementById("number").value = '';
						$("#klasMsg").html('<br/ >'); document.getElementById("classid").value = ''
						$("#egnMsg").html('<br/ >'); document.register.egn.value = '';
						$("#telefonMsg").html('<br/ >'); document.getElementById("telefon").value = '';
						$("#status").html('<br/ >'); document.getElementById("username").value = '';
						$("#passwordMsg").html('<br/ >'); document.getElementById("password1").value = '';
						$("#passwords").html('<br/ >'); document.getElementById("password2").value = '';
						$("#emailMsg").html('<br/ >'); document.getElementById("email").value = '';
					}
				}
			}
		}
		// трие клас
		function delete_class(klas) 
		{
			$("#message").html('<img src="images/loader.gif"> <b>Loading...</b>');
			var xmlhttp = GetXmlHttpObject(); 
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var klas;
			var url = 'scripts/delete_class.php?class=' + klas;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged() 
			{
				if(xmlhttp.readyState == 4)
				{
					alert("Successfully deleted class!");
					location.href = "classes.php";
				}
			}
		}
		// трие с id
		function delete_thing(id, url_send)
		{
			$("#message").html('<img src="images/loader.gif"> <b>Loading...</b>');
			var xmlhttp = GetXmlHttpObject(); 
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var url = 'scripts/' + url_send + '?id=' + id;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged() 
			{
				if(xmlhttp.readyState == 4)
				{
					hide(id);
					$("#message").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		
		function confirm_thing(id, url_send)
		{
			var classid = document.getElementById("klas").value;
			$("#"+id+"c").html('<img src="images/loader.gif">');
			var xmlhttp = GetXmlHttpObject(); 
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var url = 'scripts/' + url_send + '?id=' + id + '&classid=' +classid;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged() 
			{
				if(xmlhttp.readyState == 4)
				{
					$("#"+id+"c").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		
		// добавя паралелка
		function add_par(klas) 
		{
			$("#message").html('<img src="images/loader.gif"> <b>Loading...</b>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var paralelka = document.getElementById("paralelka").value;
			var klas;
			var url = 'scripts/add_par.php?klas=' + klas + '&paralelka=' + paralelka;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#message").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		// добавяне на предмет
		function add_subject()
		{
			$("#message").html('<img src="images/loader.gif"> <b>Loading...</b>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var predmet = document.getElementById("predmet").value;
			var url = "scripts/add_subject.php?predmet=" + predmet;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#message").hide().html(xmlhttp.responseText).fadeIn();
					document.getElementById("predmet").value = '';
					load_all_subjects();
				}
			}
		}
		// пише оценка
		function write_ocenka(studentsid)
		{
			var predmetid = document.getElementById("predmet").value;
			if(predmetid == "Предмет...")
			{
				alert("Select subject!");
				return false;
			}
			$("#message_ocenka").html('<img src="images/loader.gif"> <b>Loading...</b>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var studentsid;
			var ocenka = document.getElementById(studentsid + "o").value;
			var classid = document.getElementById("klas").value;
			var url = "scripts/write_ocenka.php?studentsid=" + studentsid + "&predmetid=" + predmetid + "&ocenka=" + ocenka + "&classid=" + classid;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged() 
			{
				if(xmlhttp.readyState == 4)
				{
					$("#" + studentsid + "r").hide().html(xmlhttp.responseText).fadeIn();
					$("#message_ocenka").html('<br />');
				}
			}
		}
		// пише забележка
		function write_zabelejka()
		{
			var predmetid = document.getElementById("predmet").value;
			if(predmetid == "Предмет...")
			{
				alert("Select subject!");
				return false;
			}
			var studentsid = document.getElementById("zabelejka_student").value;
			if(studentsid == "Ученик...")
			{
				alert('Select student!');
				return false;
			}	
			document.getElementById("message_zabelejka").innerHTML = '<img src="images/loader.gif"> <b>Loading...</b>';			
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}		
			var zabelejka = document.getElementById("zabelejka_text").value;
			var classid = document.getElementById("klas").value;
			var url = "scripts/write_zabelejka.php?zabelejka=" + zabelejka + "&studentsid=" + studentsid + "&predmetid=" + predmetid + "&classid=" + classid;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#message_zabelejka").hide().html(xmlhttp.responseText).fadeIn();
					document.getElementById("zabelejka_text").value = '';
				}
			}
		}
		function getTeachers()
		{
			document.getElementById('message').innerHTML = '<img src="images/loader.gif"> <b>Loading...</b>';
			xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var egn = document.register.egn.value;
			var url = 'scripts/get_teachers.php?egn=' + egn;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#message").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		// задава класен ръководител
		function setKlasen()
		{
			document.getElementById('message').innerHTML = '<img src="images/loader.gif"> <b>Loading...</b>';
			xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}	
			var teacherid = document.getElementById("klasen").value;
			var classid = document.getElementById("klas").value;
			var url = "scripts/set_klasen.php?teacherid=" + teacherid + "&classid=" + classid;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#message").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		// пише отсъствие
		function write_otsastvie(studentsid, otsastvie)
		{
			var predmetid = document.getElementById("predmet").value;
			if(predmetid == "Предмет...")
			{
				alert("Select subject!");
				return false;
			}
			$("#message_ocenka").html('<img src="images/loader.gif"> <b>Loading...</b>');
			xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var studentsid, otsastvie;

			var classid = document.getElementById("klas").value;
			var url = 'scripts/write_otsastvie.php?classid=' + classid + '&studentsid=' + studentsid + '&otsastvie=' + otsastvie + '&predmetid=' + predmetid;
				
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
				
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#" + studentsid + "n").hide().html(xmlhttp.responseText).fadeIn();
					$("#message_ocenka").html('<br />');
				}
			}
		}
		// зарежда оценките
		function see_ocenki()
		{
			var classid = document.getElementById("klas").value;
			var ocenki_po = document.getElementById("ocenki_po").value;
			var srok = document.getElementById("srok").value;

			if(ocenki_po == "Предмет...")
			{
				alert("Select subject!");
				return false;
			}
			$("#see_ocenki").html('<img src="images/loader.gif"> <b>Loading...</b>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var url = 'scripts/see_ocenki.php?classid=' + classid + '&predmetid=' + ocenki_po + '&srok=' + srok;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#see_ocenki").hide().html(xmlhttp.responseText).fadeIn();
				}
			}
		}
		// записва срочна/годишна оценка
		function write_srochna_godishna_ocenka(studentsid, srok)
		{
			var studentsid, srok, ocenka, tip, response
			if(srok == 'parvi')
			{
				ocenka = document.getElementById('parvi_srok' + studentsid + 'o').value;
				response = 'parvi_srok' + studentsid + 'r';
				tip = '1';
			}
			if(srok == 'vtori')
			{
				ocenka = document.getElementById('vtori_srok' + studentsid + 'o').value;
				response = 'vtori_srok' + studentsid + 'r';
				tip = '2';
			}
			if(srok == 'godishna')
			{
				ocenka = document.getElementById('godishna' + studentsid + 'o').value;
				response = 'godishna' + studentsid + 'r';
				tip = '3';
			}
				
			var predmetid = document.getElementById("ocenki_po").value;
			var classid = document.getElementById("klas").value;
			
			$("#srochna_godishna_ocenka").html('<img src="images/loader.gif"> <b>Loading...</b>');
			var xmlhttp = GetXmlHttpObject();
			if(xmlhttp == null)
			{
				alert("Your browser doesnt support AJAX");
				return;
			}
			var url = 'scripts/write_srochna_godishna_ocenka.php?classid=' + classid + '&predmetid=' + predmetid + '&tip=' + tip + '&ocenka=' + ocenka + '&studentsid=' + studentsid;
			xmlhttp.open("GET", url, true);
			xmlhttp.onreadystatechange = stateChanged;
			xmlhttp.send(null);
			
			function stateChanged()
			{
				if(xmlhttp.readyState == 4)
				{
					$("#" + response).hide().html(xmlhttp.responseText).fadeIn();
					$("#srochna_godishna_ocenka").html('<br />');
				}
			}
		}