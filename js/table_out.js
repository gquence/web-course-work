
table_outer = document.getElementById('table');

//table_gen(table_outer,  arr, 3, 3);





function lesson_table() {
    neededCookie = new Map();
    var cookie_arr = document.cookie.split(';');
    cookie_arr.forEach(function(item,i,arr)
    {
        if (item.startsWith(' subj_id'))
        {
            neededCookie.set('subj_id',item);
            document.cookie = "subj_id=empty";
        }
    });
    neededCookie.set('subj_id', neededCookie.get('subj_id').substr(9));
    if (neededCookie.get('subj_id').trim() === 'empty')
        neededCookie = new Map();
    var errorField = document.getElementById("ErrorField");

    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4)
        {
            if (this.responseText.startsWith('200\nSuccess\nGET'))
            {
                var arr = [];
                var responseText;
                if (neededCookie.size == 0)
                    responseText = this.responseText.replace('200\nSuccess\nGETALL\n','');
                else
                    responseText = this.responseText.replace('200\nSuccess\nGET\n','');
                //responseText = responseText.replace('ALL\n','');
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
                //удаление ненужных столбцов
                arr.forEach(function(item, j, arr)
                {
                    item.pop();
                });

                arr[0] = ['Lesson id', 'Lessons name', 'Description', 'Control type', 'Subject id', 'Lessons Theory', 'Recomendations for solving'];
                //console.log(arr);
                //console.log(header.length);
                //console.log(arr.length);
                arr.pop();
                table_fill(table_outer, arr, arr[0].length, arr.length);

            }
            else
            {
                alert("Error! Bad connection!" + this.responseText);
                return ;
            }
        }
    };


	//инициализируем соединения
	xhttp.open("POST", "t_lessons/CRUD_lessons.php", true);
	//устанвливаем заголовок
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    //посылаем запрос
    if (neededCookie.size == 0)
        xhttp.send("type=GETALL");
    else 
        xhttp.send("type=GET&subj_id=" + neededCookie.get('subj_id'));
    
}

function subjects_table() {
	var errorField = document.getElementById("ErrorField");

	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4)
		{
			if (this.responseText.startsWith('200\nSuccess\nGETALL'))
			{
                var arr = [];
                var responseText = this.responseText.replace('200\nSuccess\nGETALL\n','');
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
                arr.forEach(function(item, j, arr)
                {
                    item.pop();
                });
                arr.pop();

                arr[0] = ['Subject id', 'Subjects name', 'Description'];
                table_fill(table_outer, arr, arr[0].length, arr.length);

			}
			else
			{
				alert("Error! Bad connection!");
				return ;
			}
		}
    };
    	//инициализируем соединения
	xhttp.open("POST", "t_subjects/CRUD_subjects.php", true);
	//устанвливаем заголовок
	xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
	//посылаем запрос
    xhttp.send("type=GETALL");
}



function table_fill(table_outer, arr, sizeX, sizeY)
{
    //var table = document.createElement('table');
    var tr_id = "tr";
    
    for (var i = 0; i < sizeY; i++)
    {
        //var tr = document.createElement('tr');
        if (i == 0)
        {
            document.getElementById(tr_id + i.toString()).style.fontWeight = 700;
        }
        for (var j = 0; j < sizeX; j++)
        {
            var td = document.createElement('td');
            td.innerHTML = arr[i][j];
            document.getElementById(tr_id + i.toString()).appendChild(td);
        }
        //table.append(tr);
    }
    //table_outer.appendChild(table);
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

