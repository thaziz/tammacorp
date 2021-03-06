<html>
   <!-- License:  LGPL 2.1 or QZ INDUSTRIES SOURCE CODE LICENSE -->
   <head><title>QZ Print Plugin</title>
   <script type="text/javascript" src="{{ asset ('assets/jzebra/js/preparejzebra.js')}}"></script>
   <script type="text/javascript" src="{{ asset ('assets/jzebra/js/jquery-1.7.1.js')}}"></script>
   <script type="text/javascript" src="{{ asset ('assets/jzebra/js/html2canvas.js')}}"></script>
   <script type="text/javascript" src="{{ asset ('assets/jzebra/js/jquery.plugin.html2canvas.js')}}"></script>
   </head>
   <body id="content" bgcolor="#FFF380">
   <h1 id="title">QZ Print Plugin</h1><br />
   <table border="1px" cellpadding="5px" cellspacing="0px"><tr>

   <td valign="top"><h2>All Printers</h2>
   <input type=button onClick="findPrinter()" value="Detect Printer"><br />
   <input type=button onClick="findPrinters()" value="List All Printers"><br />
   <input type=button onClick="useDefaultPrinter()" value="Use Default Printer"><br /><br />
   <applet id="qz" name="QZ Print Plugin" code="qz.PrintApplet.class" width="55" height="55">
	  <param name="jnlp_href" value="qz-print_jnlp.jnlp">
          <param name="cache_option" value="plugin">
   </applet><br />

   </td><td valign="top"><h2>Raw Printers Only</h2>
   <a href="http://code.google.com/p/jzebra/wiki/WhatIsRawPrinting" target="new">What is Raw Printing?</a><br />
   <input type=button onClick="print()" value="Print" /><br />
   <input type=button onClick="print64()" value="Print Base64" /><br />
   <input type=button onClick="printPages()" value="Print Spooling Every 2" /><br />
   <input type=button onClick="printXML()" value="Print XML" /><br />
   <input type=button onClick="printHex()" value="Print Hex" /><br />
   Print File:<br />
      <input type=button onClick="printFile('zpl_sample.txt')" value="ZPL" />&nbsp;
	  <input type=button onClick="printFile('fgl_sample.txt')" value="FGL" />&nbsp;
	  <input type=button onClick="printFile('epl_sample.txt')" value="EPL" /><br />
   <input type=button onClick="printESCPImage()" value="Print ESC/POS Image" /><br />
   <input type=button onClick="printZPLImage()" value="Print ZPL Image" /><br />
   <input type=button onClick="printToFile()" value="Print To File" /><br />
   <input type=button onClick="printToHost()" value="Print To Host" /><br />
   <input type=button onClick="useAlternatePrinting()" value="Use Alternate Printing" /><br />

   </td><td valign="top"><h2>PostScript Printers Only</h2>
   <a href="http://code.google.com/p/jzebra/wiki/WhatIsPostScriptPrinting" target="new">What is PostScript Printing?</a><br />
   <input type=button onClick="printHTML()" value="Print HTML" /><br />
   <input type=button onClick="printPDF()" value="Print PDF" /><br />
   <input type=button onClick="printImage(false)" value="Print PostScript Image" /><br />
   <input type=button onClick="printImage(true)" value="Print Scaled PostScript Image" /><br />
   <input type=button onClick="printPage()" value="Print Current Page" /><br />
   <input type=button onClick="logFeatures()" value="Log Printer Features on Print" /><br />

   </td><td valign="top"><h2>Serial</h2>
   <input type=button id="list_ports" onClick="listSerialPorts()" value="List Serial Ports" /><br />
   <input type=text id="port_name" size="8" />
   <input type=button id="open_port"  onClick="openSerialPort()" value="Open Port" /><br />
   <input type=button id="send_data" onClick="sendSerialData()" value="Send Port Cmd" /><br />
   <input type=button id="close_port"  onClick="closeSerialPort()" value="Close Port" /><br />
   <hr /><h2>Misc</h2>
   <input type=button onClick="allowMultiple()" value="Allow Multiple Applets" /><br /></td></tr></table>
   </body><canvas id="hidden_screenshot" style="display:none;" />
</html>
