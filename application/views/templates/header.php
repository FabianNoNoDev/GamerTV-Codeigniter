<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo $site_options['site_description']; ?>">
    <meta name="author" content="Gamertv@Leeroy">
    <link rel="icon" href="<?php echo base_url(); ?>assets/icon/index.ico">

    <title><?php echo $site_options['site_title']; ?></title>
    <link href='//fonts.googleapis.com/css?family=Play:400,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" >
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css" >
    <link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/gamertv.css">
    
       <script type="text/javascript">

        function display_c(){
        var refresh=100000; // Refresh rate in milli seconds
        mytime=setTimeout("charlist()",refresh)
        }


        function charlist () {

                xmlhttp = new XMLHttpRequest();

                xmlhttp.onreadystatechange = function() {


                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    }

                }
                xmlhttp.open("GET","streamupdater.php",true);
                xmlhttp.send();  

        display_c();
        }

        </script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>


  <body>
    <script type="text/javascript">
        window.onload =  charlist;
        
    </script>
    <div class="navbar-wrapper">
      <div class="container">

        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a href="../" class="navbar-brand">GamerTV</a>
            </div>
            <div class="navbar-collapse collapse" id="navbar">
              <ul class="nav navbar-nav">
                <li class="<?php if($this->uri->segment(1)=="stream"){echo "active";}?>"><a href="../stream"><?php echo ucfirst($site_lang['streams']); ?></a></li>
                <li class="<?php if($this->uri->segment(1)=="top"){echo "active";}?>"><a href="../top"><?php echo ucfirst($site_lang['top100']); ?></a></li>
                <li class="<?php if($this->uri->segment(1)=="pages"){echo "active";}?>"><a href="../pages/about"><?php echo ucfirst($site_lang['about']); ?></a></li>
              </ul>
                
            <?php if ($user['email']=="") {?>    
              <ul class="nav navbar-nav navbar-right ">
                 <li><a href="../auth/login"><?php echo ucfirst($site_lang['login']); ?></a></li>
            </ul>
            <?php } else { ?>
              <ul class="nav navbar-nav navbar-right ">
                <li class="dropdown">
                   <li>
                   <a href="<?php echo base_url(); ?>acp">Admin Panel</a>
                   </li> 
                   <li>
                   <a href="<?php echo base_url(); ?>auth/logout"><i class="fa fa-fw fa-power-off"></i><?php echo ucfirst($site_lang['logout']); ?></a>
                  </li>
                </li>
            </ul>  
            <?php  } ?>  
                
                
            </div>
          </div>
        </nav>

      </div>
    </div>

    <div class="container" style="padding-top: 80px;">