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
        document.getElementById(tr_id + i.toString()).onclick = function(){ setSelectedRow(i);};
        document.getElementById(tr_id + i.toString()).style.background = "#8ad83d";
        //console.log(document.getElementById(tr_id + i.toString()));
    }
}

function tryToPassBtn()
{
    var tr_id = "tr";

    if (selectedRow == 0)
    {
        alert("You need to choose a subject");
    }
    else
    {
		document.cookie = "subj_id=" + document.getElementById(tr_id + selectedRow.toString()).getElementsByTagName("td")[0].innerText;
        window.location = 'http://localhost/lessons.html';
    }
}
