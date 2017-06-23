<?php  include("includes/admin-config.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>IN ADMIN PANEL | Powered by chintanhingrajiya@gmail.com</title>
        <link rel="stylesheet" type="text/css" href="<?=ADMIN_BASE_PATH?>style.css" />
        <script type="text/javascript" src="<?=ADMIN_BASE_PATH?>jquery.min.js"></script>
        <script type="text/javascript" src="<?=ADMIN_BASE_PATH?>ddaccordion.js"></script>
        <script type="text/javascript">
            ddaccordion.init({
                headerclass: "submenuheader", //Shared CSS class name of headers group
                contentclass: "submenu", //Shared CSS class name of contents group
                revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
                mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
                collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
                defaultexpanded: [], //index of content(s) open by default [index1, index2, etc] [] denotes no content
                onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
                animatedefault: false, //Should contents open by default be animated into view?
                persiststate: true, //persist state of opened contents within browser session?
                toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
                togglehtml: ["suffix", "<img src='<?=ADMIN_BASE_PATH?>images/plus.gif' class='statusicon' />", "<img src='<?=ADMIN_BASE_PATH?>images/minus.gif' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
                animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
                oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
                    //do nothing
                },
                onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
                    //do nothing
                }
            })
        </script>
        <script src="<?=ADMIN_BASE_PATH?>jquery.jclock-1.2.0.js.txt" type="text/javascript"></script>
        <script type="text/javascript" src="<?=ADMIN_BASE_PATH?>jconfirmaction.jquery.js"></script>
        <script type="text/javascript">
            setTimeout(function() {
                $('#dddd').fadeOut('slow');
            }, 4000); // <-- time in milliseconds

            $(document).ready(function() {
                $('.ask').jConfirmAction();
            });

        </script>
        <script type="text/javascript">
            $(function($) {
                $('.jclock').jclock();
            });
        </script>

        <script language="javascript" type="text/javascript" src="<?=ADMIN_BASE_PATH?>niceforms.js"></script>
        <link rel="stylesheet" type="text/css" media="all" href="<?=ADMIN_BASE_PATH?>niceforms-default.css" />

    </head>
    <body>
        
        <div id="main_container">
            
            <div class="header">
                <img src="<?=ADMIN_BASE_PATH?>images/AdminLogo.gif" width="305" />
                <?php
                    if($_SESSION['admin_name'] != '')
                    {
                        ?>   <div class="right_header">Welcome <?=$_SESSION['admin_name']?> | <a href="<?=ADMIN_BASE_PATH?>logout.php" class="logout">Logout</a></div>
                       
                        <?php
                        
                    }
                    ?>
                <div class="jclock"></div>
            </div>
             <div class="main_content">
                <?php
                    if($_SESSION['admin_name'] != '')
                    {
                        include 'menu.php';
                    }
                    ?>
<div class="center_content">  
            <?= $CurrentMessage ?>