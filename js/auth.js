function auth(form) {
	// form.action="t_users/CRUD_user.php"
	var errorField = document.getElementById("ErrorField");

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4)
		{
			if (this.responseText == 'true\n200\nSuccess\nAUTH\n')
			{
				document.cookie = "login=" + login;
				document.cookie = "pass=" + password;
				window.location = "http://localhost/main.html";
			}
			else if (this.responseText ==  '301\nInvalidJsonValues: wrong password\nAUTH\n')
			{
				alert("Error! Wrong password!");
				return ;
			}
			else if (this.responseText.startsWith('301\nInvalidJsonValues: no such user'))
			{
				alert("Error! No such user");
				return ;
			}
			else
			{
				alert("Error! Wrong values of login of password fields"  + this.responseText);
				return ;
			}
		}
	};

	var login = form.login.value;
	var password = form.password.value;

	//инициализируем соединения
	xhttp.open("POST", "t_users/CRUD_user.php", true);
	//устанвливаем заголовок
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
	//посылаем запрос
    xhttp.send("type=AUTH&sOp=true&login=" + login + "&pass=" + password);
	
}