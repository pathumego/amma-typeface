// onscreen keyboard - Copyright (C) Kaveen Goonawardane @ ParadoxSoftware(Pvt)Ltd.

// Adding characters to the textbox
function addthis(character,type){
	triggerTextAreaChange();
	
	document.keyform.textbox.value = document.keyform.textbox.value + character;
	if(type>=1)
	{
		if (type==2)
		{
		    keyclass='compound';
		    document.getElementById('compoundchars').style.visibility='hidden';
		}
		else
		{
		    keyclass='normal';
		    prevchar='';
		    document.getElementById('compoundchars').style.visibility='visible';
		}
		updatekeyboard(prevchar+character,keyclass);
		document.getElementById('vowelmodifiers').style.visibility='visible';
		prevchar=character;
	}
	else
	{
		document.getElementById('vowelmodifiers').style.visibility='hidden';
		document.getElementById('compoundchars').style.visibility='hidden';
	}
}

//Deleting characters one by one
function backspace()
{
	document.getElementById('vowelmodifiers').style.visibility='hidden';
	document.getElementById('compoundchars').style.visibility='hidden';
	
	var temp=document.keyform.textbox.value;
	document.keyform.textbox.value='';
	var x;
	for(x=0;x<temp.length-1;x++)
	{
		document.keyform.textbox.value=document.keyform.textbox.value+temp.charAt(x);
	}
	updatekeyboard(document.keyform.textbox.value.charAt(x-1));
}

//Updates the fourth block of the keyboard
function updatekeyboard(val, keyclass)
{
	var specialchars = new Array();
	specialchars[0] = new Array();
	document.getElementById('1').value=val+'\u0DCA';
	document.getElementById('2').value=val+'\u0DCF';
	document.getElementById('3').value=val+'\u0DD0';
	document.getElementById('4').value=val+'\u0DD1';
	document.getElementById('5').value=val+'\u0DD2';
	document.getElementById('6').value=val+'\u0DD3';
	document.getElementById('7').value=val+'\u0DD4';
	document.getElementById('8').value=val+'\u0DD6';
	document.getElementById('9').value=val+'\u0DD8';
	document.getElementById('10').value=val+'\u0DD9';
	document.getElementById('11').value=val+'\u0DDA';
	document.getElementById('12').value=val+'\u0DF2';
	document.getElementById('13').value=val+'\u0DDB';
	document.getElementById('14').value=val+'\u0DDC';
	document.getElementById('15').value=val+'\u0DDD';
	document.getElementById('16').value=val+'\u0DDE';
	document.getElementById('17').value=val+'\u0DDF';
	if (keyclass=='normal')
	{
	    document.getElementById('c1').value=val+'\u0DCA'+'\u200D'+'\u0DBB';
	    document.getElementById('c2').value=val+'\u0DCA'+'\u200D'+'\u0DBA';
	}
}

//copy the text to clipboard
function copyit(theField) {
    var tempval=eval("document."+theField)
    tempval.focus()
    tempval.select()
    therange=tempval.createTextRange()
    therange.execCommand("Copy")
}

function Update(){
  var e2 = unescape(document.addressbook.remainingstr.value);
  for (var i = 0; i < document.addressbook.elements.length; i++){
     var e = document.addressbook.elements[i];
     if (e.name == "to" && e.checked){
        if (e2)
           e2 += ",";
        e2 += e.value;
     }
  }
  window.opener.document.composeform.to.value = e2;
  window.close();
}