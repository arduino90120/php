
<body bgcolor = black text = # ff0000>

Home

<center>

<h1> CONTROLLER OF ELECTRONIC BOARDS </ h1>

Home

<font color = # ffffff>

<form action = "<? php echo $ _SERVER 'PHP_SELF';?>" method = "POST">

<table border = 0 width = 360>

<td align = "right">

<b> HOST / IP: </ b>

<b> Message: </ b> <br> <br> <br> <br> The Internet Movie Database

<b> Effect: </ b> <br>

</ td>

<td>

<input type = "text" name = "host"

<textarea rows = 3 cols = 30 name = "message"> </ textarea> <br> <br>

<select name = "effect">

<option value = 0> Fixed </ option>

<option value = 1> Flashing </ option>

<option value = 2> Scroll left </ option>

<option value = 3> Displacement der </ option>

<option value = 4> Zig Zag 1 </ option>

<option value = 5> Zig Zag 2 </ option>

<option value = 6> Zig Zag 3 </ option>

<option value = 7> Waterfall below </ option>

<option value = 8> Waterfall above </ option>

<option value = 9> Normal left </ option>

<option value = 10> Thick letter </ option>

</ select> <br>

</ td>

</ table>

Home

<input type = "submit" value = "Send" name = "click">

<br> <br> <hr>

</ form>

</ body>

</ html>

<? php

define ("TAB_LONGITUD", 21);

define ("TABINIMSG", "\ xac \ xe1");

define ("TABFINMSG", "\ x8b \ x34");

define ("TAB_PUERTO", 2000);

define ("TAB_TIMEOUT", 7); //Seconds

define ("CHAR_RELLENO", "*");

define ("EFFECT_DEFAULT", 0x09);

POST 'message') && isset ($ POST 'host') && isset ($ POST 'effect')

$ host = $ _POST 'host';

$ message = $ _POST 'message';

$ effect = $ _POST 'EFFECT';

if (! ($ board = @ fsockopen ($ host, TABPUERTO, $ errno, $ errstring, TABTIMEOUT)) {

echo "<br> <b> ERROR ($ errno): $ errstring </ b> <br>";

exit (1);

}

$ fx = 0x80 + $ effect;

$ non-printable = array ('' '' '' '' '' '' '' '' '' '' '' '' '' '' , 'š', 'Ž');

$ clean = FALSE;

if (empty ($ message)) {

$ clean = TRUE;

$ message = strpad ($ message, TABLONGITUD + 1, "", STRPADBOTH);

}

$ message = str_replace ($ non-printable, '', $ message); // Delete the non-printable ones by the board

$ message = strtr ($ message, "aéióúñÁÉÍÓÚÑ", "aeiounAEIOUN"); // Remove accents and tilde

$ message = str_replace ("\ r", '', $ message); // Delete Carriage Return

$ message = str_replace ("\ n", '', $ message); // Delete Line Feed

$ message = str_replace ("\ t", '', $ message); // Delete Tabular

/ ************* /

if (! $ clean)

if ($ fx == 0x89 || $ fx == 0x8a) {// Long messages

$ message = strpad ($ message, strlen ($ message) + 2, "", STRPAD_BOTH);

$ message = strpad ($ message, strlen ($ message) + 6, CHARRELLENO, STRPADBOTH);

$ message = strpad ($ message, strlen ($ message) + TABLONGITUD * 2 + 2, "", STRPADBOTH);

} else {// Short Messages

if (strlen ($ message)> = TAB_LONGITUD)

$ message = substr ($ message, 0, TAB_LONGITUD). "";

else

switch (strlen ($ message)) {

case (TAB_LONGITUD - 1):

$ message. = "";

break;

case (TAB_LONGITUD - 2):

$ message = "". $ message. "";

break;

case (TAB_LONGITUD - 3):

$ message = "". $ message. "";

break;

default:

$ message = "". $ message. "";

$ message = strpad ($ message, TABLONGITUD, CHARRELLENO, STRPAD_BOTH). "";

}

}

$ buff = TABINIMSG. chr ($ fx). $ message. TABFINMSG;

fwrite ($ board, $ buff);

echo "<br> <b> REPLY OF THE BOARD: </ b>";

$ answer = fread ($ board, 16);

fclose ($ board);

if (! strstr ($ answer, "OK"))

echo "FAIL!";

else

echo "OK!";

}

?>

