var cookie_arr = document.cookie.split(';');

var login_pass = [];

cookie_arr.forEach(function(item,i,arr)
{
    if (item.startsWith(' login'))
        login_pass['login'] = item;
    if (item.startsWith(' pass'))
        login_pass['pass'] = item;
});

login_pass['pass'] = login_pass['pass'].substr(6);
login_pass['login'] = login_pass['login'].substr(7);

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
	if (this.readyState == 4)
	{
		if (this.responseText == 'true\n200\nSuccess\nAUTH\n')
		{
		}
		else
		{
            window.location.pathname = "/index.html";
			return ;
		}
	}
};
//инициализируем соединения
xhttp.open("POST", "t_users/CRUD_user.php", true);
//устанвливаем заголовок
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
//посылаем запрос
xhttp.send("type=AUTH&sOp=true&login=" + login_pass['login'] + "&pass=" + login_pass['pass']);


function exit()
{
    document.cookie = "login=a";
    document.cookie = "pass=a";
    window.location.pathname = "/index.html";
}