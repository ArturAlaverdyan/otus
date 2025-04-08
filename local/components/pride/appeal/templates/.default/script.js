let buttCancel = document.querySelector("input[name='buttCancel']");
let buttPrint = document.querySelector("input[name='buttPrint']");
let dateInputs = document.querySelectorAll(".tableCreateAppeal input[type='date'], .tableCreateAppeal input[type='time']");
let fileInputs = document.querySelectorAll(".tableCreateAppeal input[type='file']");


buttCancel.onclick = function () { // ПРИ НАЖАТИИ КНОПКИ НАЗАД
	window.location.href = '/services/web_docs/';
};

buttPrint.onclick = function () { // ПРИ НАЖАТИИ КНОПКИ ПЕЧАТЬ

	document.querySelector(".titleAppeal").style = "display: none;";
	document.querySelector(".tableCreateAppeal").style = "display: none;";
	if (document.querySelector(".side-panel-toolbar-toggle")) document.querySelector(".side-panel-toolbar-toggle").style = "display: none;";
	document.querySelector(".textForPrint").setAttribute("style","display: block"); // ДОБАВИТЬ НОВЫЕ ЗНАЧЕНИЯ В ДОКУМЕНТ

	window.scroll(0, 0); 
	setTimeout(function() {window.print()}, 0);
};

if (document.location.href.includes("srazu=1")) // ЕСЛИ НУЖНО СРАЗУ ОТКРЫТЬ ФОРМУ ДЛЯ ПЕЧАТИ
{
	buttPrint.click();
}

if (dateInputs)
{
	for (i = 0; i < dateInputs.length; i++)
	{
		dateInputs[i].onclick = function () {
			this.showPicker();
		}
	}
}

if (fileInputs)
{
	for (i = 0; i < fileInputs.length; i++)
	{
		fileInputs[i].onchange = function () {
			if (this.value != '')
			{
				this.nextSibling.textContent = this.value;
			}
		}
	}
}

let check1 = document.querySelectorAll("input[name='1172!#!0']"); // ПРОЦЕСС ОТПУСКА, ИСЧЕЗАНИЕ ЧЕКБОКСА ПО НАЖАТИЮ СЕЛЕКТА
let select1 = document.querySelector("select[name='1169']");

if (check1[0])
{
	select1.onchange = function () {
		if (select1.value == "Оплачиваемый")
		{
			check1[0].value = 0;
			check1[1].checked = false;
			check1[1].parentElement.parentElement.parentElement.style += "display:table;";
		}
		else {
			check1[0].value = 1;
			check1[1].checked = true;
			check1[1].parentElement.parentElement.parentElement.style = "display:none;";
		}
	}

}