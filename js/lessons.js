var selectedRow = 0;


function setSelectedRow(i)
{
    var tr_id = "tr";
    
    document.getElementById(tr_id + selectedRow.toString()).style.background = "white";
    document.getElementById(tr_id + i.toString()).style.background = "#8ad83d";
    selectedRow = i;
}



function loading()
{
    var tr_id = "tr";
    
    for (var i = 1; i < 30; i++)
    {
        //document.getElementById(tr_id + i.toString()).onclick = function(){ setSelectedRow(i);};
        //document.getElementById(tr_id + i.toString()).style.background = "#8ad83d";
        //console.log(document.getElementById(tr_id + i.toString()));
    }
}

function tryToPassBtn()
{
    var tr_id = "tr";

    if (selectedRow == 0)
    {
        alert("You need to choose a lesson");
    }
    else
    {
		document.cookie = "l_id=" + document.getElementById(tr_id + selectedRow.toString()).getElementsByTagName("td")[0].innerText;
        document.cookie = "l_type=" + document.getElementById(tr_id + selectedRow.toString()).getElementsByTagName("td")[3].innerText;
        //alert(document.cookie);
        window.location = 'http://localhost/doing_tasks.html';
    }
}
