<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3c.org/TR/1999/REC-html401-19991224/loose.dtd">
<html>
  <head>

    <title><?php echo $this->title ?></title>
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
  
    <style type="text/css">
  
    .text_def
    {
      font-size: 13px; 
      line-height: 11pt; 
      text-decoration: none; 
      color:#333333;
      font-family:Arial, Helvetica, sans-serif;
    }
    
    .link_def
    {
      font-size: 13px; 
      line-height: 11pt; 
      text-decoration: none; 
      color:#008000;
      border-bottom:dotted;
      font-family:Arial, Helvetica, sans-serif;
    }
  
    </style>
  
  </head>
  <body>

  <?php echo ($CONTENT?$CONTENT:$this->buildMainContent($TEMPLATE)) ?>

  </body>
</html>
