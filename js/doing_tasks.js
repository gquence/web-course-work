var arr = [];
table_outer = document.getElementById('table');
var cookie_arr = document.cookie.split(';');
var uid;
var neededCookie = [];
var deadline;
var disable_EndBtn = false;
var TimeIsUp = false;

cookie_arr.forEach(function(item,i,arr)
{
    if (item.startsWith(' l_id'))
        neededCookie['l_id'] = item;
    if (item.startsWith(' l_type'))
        neededCookie['l_type'] = item;
    if (item.startsWith(' login'))
    neededCookie['login'] = item;
});

neededCookie['l_id'] = neededCookie['l_id'].substr(6);
neededCookie['l_type'] = neededCookie['l_type'].substr(8);
neededCookie['login'] = neededCookie['login'].substr(7);
//установка UID
get_uid('t_users/CRUD_user.php', 'type=GET&login=' + neededCookie['login']);


pageHeader = document.getElementById('header');
timer = document.getElementById('timer');
pageHeader.innerHTML =  neededCookie['l_type'];

var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function() {
	if (this.readyState == 4)
	{
        //console.log(this.responseText + "\n");  
        if (this.responseText == "200\nSuccess\nGET\nresult: No tasks with this id or l_id&")
        {
            res = confirm("No available tasks for this lesson. Contact with your Educator.\n Do you want to stay here?");
            if (!res)
                window.location.pathname = "/lessons.html";
        }
		if (this.responseText.startsWith('200\nSuccess\nGET\n'))
		{
            
            var responseText = this.responseText.replace('200\nSuccess\nGET\n','');
            responseText = responseText.replace(/\[/g,'');
            responseText = responseText.split("]&");
            // загрузка хэдэров таблицы
            var header = responseText[0].replace(/\s[\d\w@\-\s?!.]*\&/g,'').replace(' ', '').split(':');
            header.pop();
            arr.push(header);
            //console.log(header);

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
            arr.pop();
            arr.forEach(function(item, j, arr)
            {
                item.splice(1, 1);
                
            });
            
            arr.forEach(function(item, j, arr)
            {
                if (j != 0  && item[3].match(/ {[\w,"'\s]+}/))
                {
                    var ans_arr = item[3].replace(/[\{}]+/g, '').split(',');
                    ans_arr[0].replace(' ', '');
                    ans_arr.forEach(function(item_1, j1, arr1)
                    {
                        item_1 = item_1.replace(/["]+/g,'');
                    });
                    item[3] = ans_arr;
                }
                
            });

            arr[0] = ['task_id','Question', 'Correct answer', 'Answer'];

            task_table_gen(table_outer, arr, arr.length);
		}
		else
		{
			return ;
		}
	}
};
//инициализируем соединения
xhttp.open("POST", window.location.protocol + "//" +window.location.host + "/t_tasks/CRUD_tasks.php", true);
//устанвливаем заголовок
xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
//посылаем запрос
xhttp.send("type=GET&l_id=" + neededCookie['l_id']);

deadline = createDeadline(new Date(), 15);
if (neededCookie['l_type'] == "Exam")
    initializeClock(deadline); 

function initializeClock(deadline){
    var timeinterval = setInterval(function(){
      var t = getTimeRemaining();
      timer.innerHTML = 'hours: '+ t.hours + '<br>' +
                        'minutes: ' + t.minutes + '<br>' +
                        'seconds: ' + t.seconds;
      if(t.total<=0){
        if (!TimeIsUp){
            timer.innerHTML = "Time is up"
            disable_EndBtn = true;
            alert("Time is up!\nYour current answers were sent");
            sendAnswer();  
            TimeIsUp = true;
        }
    }
    },1000);
  }

function getTimeRemaining(){
    var t = Date.parse(deadline) - Date.parse(new Date());
    var seconds = Math.floor( (t/1000) % 60 );
    var minutes = Math.floor( (t/1000/60) % 60 );
    var hours = Math.floor( (t/(1000*60*60)) % 24 );
    var days = Math.floor( t/(1000*60*60*24) );
    return {
      'total': t,
      'days': days,
      'hours': hours,
      'minutes': minutes,
      'seconds': seconds
    };
}

function createDeadline(start ,minutes)
{
    // minutes * 60000 - перевод в миллисекунды
    return new Date(start.getTime() + minutes * 60000);
}


function task_table_gen(table_outer, arr, sizeY)
{
    var table = document.createElement('table');
    
    for (var i = 0; i < sizeY; i++)
    {
        var tr = document.createElement('tr');
        if (i == 0)
        {
            tr.style.fontWeight = 700;
        }
        var td1 = document.createElement('td');
        td1.innerHTML = arr[i][1];
        tr.appendChild(td1);

        var td2 = document.createElement('td');
        if (i == 0)
        {
            td2.innerHTML = arr[i][3];
        }
        //добавляем селекты, если вариантов много
        else if (Array.isArray(arr[i][3]))
        {
            var tmp_input = document.createElement('select');
            tmp_input.setAttribute('id', 'selectInput' + i.toString());
            //tmp_input.setAttribute('class', '');
            arr[i][3].forEach(function(item, i, arr)
            {
                var option = document.createElement('option');
                option.value = item;
                option.text = item;
                tmp_input.appendChild(option);
            });
            td2.appendChild(tmp_input);
        }
        //добавляем инпуты, если вариантов нет
        else
        {
            var tmp_input = document.createElement('input');
            tmp_input.setAttribute('id', 'input' + i.toString());
            //tmp_input.setAttribute('class', '');
            td2.appendChild(tmp_input);
        }
        tr.appendChild(td2);

        table.append(tr);
    }
    table_outer.appendChild(table);
}

function ft_close()
{
    return 'Are you sure, you want to come out from this page?\nYour results will be erased';
}

function ft_out()
{

    window.location.pathname = "main.html";
}
function sendAnswer()
{
    if (TimeIsUp)
    {
        return ;
    }
    if (!disable_EndBtn)
    {
        var conf = confirm('Are you sure, you want to end this?\nYour results will be sent immediatly');
        if (!conf)
        {
            return ;
        }
    }
    for (var i = 1; i < arr.length; i++)
    {
        var postRequest = "type=POST&uid=" + uid.toString().trim() + "&task_id=" + arr[i][0].toString().trim() + "&";

        var res;
        if (Array.isArray(arr[i][3]))
        {
            var tmp_input = document.getElementById('selectInput' + i.toString());
            res = tmp_input.value;
        }
        else
        {
            var tmp_input = document.getElementById('input' + i.toString());
            res = tmp_input.value;
        }

        if (res.trim() == arr[i][2].trim())
            postRequest += "correct=true&";
        else
            postRequest += "correct=false&";
        if (res.trim() == '')
            res = '301empty';

        postRequest += "users_ans=" + res.trim().toString() + "&";
        
        resp = post_task('t_tasks_users/CRUD_tasks.php', postRequest);

        if (!resp)
        {
            ft_out();
        }
    }
    setTimeout(()=> {ft_out();}, 4);
    TimeIsUp = true;
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
// синхронная отправка запросов, чтобы успели загрузкиться все данные перед переходом на другую страницу (см вызов post_task)
function post_task(location, data)
{
    var xhttp = new XMLHttpRequest();

    console.log(data);
    //инициализируем соединения
    xhttp.open("POST", location, false);
    //устанвливаем заголовок
    xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=utf-8");
    //посылаем запрос
    xhttp.send(data);
    if (xhttp.responseText.startsWith('200\nSuccess\nPOST'))
    {
        console.log("200 Success POST");
        return true;
    }
    else
    {
        alert("Your answers wasn't accepted.\n Maybe you were trying to solve before");
        return false;
    }
}
