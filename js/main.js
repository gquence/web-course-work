
var login= "";
var cookie_arr = document.cookie.split(';');
cookie_arr.forEach(function(item,i,arr)
{
    if (item.startsWith(' login'))
        login = item;
});
login = login.substr(7);
uid = get_uid('t_users/CRUD_user.php', 'type=GET&login=' + login);


user_info_table();

function user_info_table() {
    table_outer = document.getElementById('UserTable');
	var errorField = document.getElementById("ErrorField");

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4)
		{
            if (this.responseText.startsWith('200\nSuccess\nGET\n'))
			{
                var arr = [];
                var responseText = this.responseText.replace('200\nSuccess\nGET\n','');
                responseText = responseText.replace(/\[/g,'');
                responseText = responseText.split("]&");
                // загрузка хэдэров таблицы
                var header = responseText[0].replace(/\s[\s\d\w@\-?]*&/g,'').replace(' ', '').split(':');
                header.pop();
                arr.push(header);

                //парсинг для получения значений столбцов
                for (var i = 0; i < responseText.length; i++)
                {
                    resp_tmp = responseText[i].replace(" ", '');
                    header.forEach(function(item, j, arr)
                    {
                        resp_tmp = resp_tmp.replace(item,'');
                    });
                    resp_tmp = resp_tmp.replace(/:/g, '').split('&');
                    
                    resp_tmp.pop();
                    arr.push(resp_tmp);
                }
                //удаление ненужных столбцов
                //console.log(arr);
                arr.forEach(function(item, j, arr)
                {
                    item.splice(0,1);
                    item.unshift(item.splice(4,1)[0]);
                    item.splice(4,1);
                });
                arr[1][3] = (arr[1][3].trim() == 't') ? 'Student' : 'Pedago';
                arr[0] = ['Login', 'Surname', 'Name', 'Position', 'E-mail'];
                table_gen(table_outer, arr, arr[0].length, arr.length);
                main_lesson_table();
			}
			else
			{
				alert("Error! Bad connection!");
				return ;
			}
		}
    };
    	//инициализируем соединения
	xhttp.open("POST", "/t_users/CRUD_user.php", true);
	//устанвливаем заголовок
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
	//посылаем запрос
    xhttp.send("type=GET&login=" + login);
}

function main_lesson_table() {
	var errorField = document.getElementById("ErrorField");
    table_outer = document.getElementById('table');

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4)
		{
            if (this.responseText === '200\nSuccess\nGETALL\n')
            {
                table_gen(table_outer, [["You have not any exams"]], 1, 1);
                results_report_table();
            }
			if (this.responseText.startsWith('200\nSuccess\nGETALL'))
			{
                var arr = [];
                var responseText = this.responseText.replace('200\nSuccess\nGETALL\n','');
                responseText = responseText.replace(/\[/g,'');
                responseText = responseText.split("]&");
                // загрузка хэдэров таблицы
                var header = responseText[0].replace(/\s[\s\d\w@\-]*&/g,'').replace(' ', '').split(':');
                header.pop();
                arr.push(header);

                //парсинг для получения значений столбцов
                for (var i = 0; i < responseText.length; i++)
                {
                    resp_tmp = responseText[i].replace(" ", '');
                    header.forEach(function(item, j, arr)
                    {
                        resp_tmp = resp_tmp.replace(item,'');
                    });
                    resp_tmp = resp_tmp.replace(/:/g, '').split('&');
                    
                    if (resp_tmp[3] == " Exam")
                    {
                        resp_tmp.pop();
                        arr.push(resp_tmp);
                    }
                }
                //удаление ненужных столбцов
                arr.forEach(function(item, j, arr)
                {
                    item.splice(0, 1);
                    item.splice(3, 1);
                    item.pop();
                    item.pop();
                    item.pop();
                });

                if (arr.length == 1)
                {
                    table_gen(table_outer, ["You have not any exams"], 1, 1);
                }
                arr[0] = ['Lessons names', 'Descriptions', 'Control type'];
                //console.log(arr);
                //console.log(header.length);
                //console.log(arr.length);
                table_gen(table_outer, arr, arr[0].length, arr.length);
                results_report_table();
			}
			else
			{
				alert("Error! Bad connection!");
				return ;
			}
		}
    };
    	//инициализируем соединения
	xhttp.open("POST", "t_lessons/CRUD_lessons.php", true);
	//устанвливаем заголовок
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
	//посылаем запрос
    xhttp.send("type=GETALL");
}

function results_report_table() {
	var errorField = document.getElementById("ErrorField");
    table_outer = document.getElementById('ResultsTable');

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4)
		{console.log(this.responseText);
			
            if (this.responseText === '200\nSuccess\nGETREPORT\n')
            {
                table_gen(table_outer, [["You hadn't solve anything yet"]], 1, 1);
            }
			if (this.responseText.startsWith('200\nSuccess\nGETREPORT\n'))
			{
                var arr = [];
                var responseText = this.responseText.replace('200\nSuccess\nGETREPORT\n','');
                responseText = responseText.replace(/\[/g,'');
                responseText = responseText.split("]&");
                // загрузка хэдэров таблицы
                var header = responseText[0].replace(/\s[\s\d\w@\-]*&/g,'').replace(' ', '').split(':');
                header.pop();
                arr.push(header);

                //парсинг для получения значений столбцов
                for (var i = 0; i < responseText.length; i++)
                {
                    resp_tmp = responseText[i].replace(" ", '');
                    header.forEach(function(item, j, arr)
                    {
                        resp_tmp = resp_tmp.replace(item,'');
                    });
                    resp_tmp = resp_tmp.replace(/:/g, '').split('&');
                    
                    resp_tmp.pop();
                    arr.push(resp_tmp);
                }
                arr.pop();
                //удаление ненужных столбцов
                arr.forEach(function(item, j, arr)
                {
                    item[3] = (item[3].trim() === '301empty') ? "'empty value'" : item[3];
                    item[2] = (item[2].trim() === 't') ? 'true' : 'false';
                });

                arr[0] = ['Lessons names', 'Questions', 'Evaluations', 'Your Answers'];
                console.log(arr);
                //console.log(header.length);
                //console.log(arr.length);
                table_gen(table_outer, arr, arr[0].length, arr.length);

			}
			else
			{
				alert("Error! Bad connection!");
				return ;
			}
		}
    };
    	//инициализируем соединения
	xhttp.open("POST", "t_tasks_users/CRUD_tasks.php", true);
	//устанвливаем заголовок
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
	//посылаем запрос
    xhttp.send("type=GETREPORT&uid=" + uid.toString());
}



function table_gen(table_outer, arr, sizeX, sizeY)
{
    var table = document.createElement('table');
    
    for (var i = 0; i < sizeY; i++)
    {
        var tr = document.createElement('tr');
        if (i == 0)
        {
            tr.style.fontWeight = 700;
        }
        for (var j = 0; j < sizeX; j++)
        {
            var td = document.createElement('td');
            td.innerHTML = arr[i][j];
            tr.appendChild(td);
        }
        table.append(tr);
    }
    table_outer.appendChild(table);
}


function get_uid(location, data)
{
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.responseText.startsWith('200\nSuccess\nGET\nuid:'))
        {
            res = this.responseText.replace('200\nSuccess\nGET\n', '');
            uid = parseInt(/[\d]+/.exec(res)[0]);
        }
    };
    //инициализируем соединения
    xhttp.open("POST", location, true);
    //устанвливаем заголовок
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    //посылаем запрос
    xhttp.send(data);
}