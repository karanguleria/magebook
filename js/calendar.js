var bustcachevar=1; //bust potential caching of external pages after initial request? (1=yes, 0=no)
var bustcacheparameter="";

var siteurl = document.location.origin;

function createRequestObject(){
	try	{
		xmlhttp = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
	}	catch(e)	{
		alert('Sorry, but your browser doesn\'t support XMLHttpRequest.');
	};
	return xmlhttp;
};

function ajaxpage(url, containerid){
	var page_request = createRequestObject();
	
	if (bustcachevar) bustcacheparameter=(url.indexOf("?")!=-1)? "&"+new Date().getTime() : "?"+new Date().getTime()
	page_request.open('GET', url+bustcacheparameter, true)
	page_request.send(null)

console.log(url);

	page_request.onreadystatechange=function(){
		loadpage(page_request, containerid)
	}
}

function loadpage(page_request, containerid){
	if (page_request.readyState == 4 && (page_request.status==200 || window.location.href.indexOf("http")==-1)) {
	    document.getElementById(containerid).innerHTML=page_request.responseText;
	};
}


function LoadMonth(month, year) {
	ajaxpage(siteurl+"/wp-content/themes/magbook/event-calendar.php?month="+month+"&year="+year, "Calendar");
	//alert(1);

}

function LoadEvents(date) {
	ajaxpage("calendar.php?date="+date, "Events");
	//alert(2);
}

LoadMonth();