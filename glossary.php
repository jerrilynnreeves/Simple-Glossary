<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="3600" />
<meta name="revisit-after" content="2 days" />
<meta name="robots" content="index,follow" />
<meta name="publisher" content="" />
<meta name="copyright" content="2008" />
<meta name="distribution" content="global" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<link rel="stylesheet" type="text/css" media="screen,projection,print" href="site/clientname.css"/>
<script type="text/javascript" src="site/jquery.js"></script>
<script type="text/javascript" src="site/clientname.js"></script>
<title>Php code I wrote in 2008 for a glossary database</title>

</head>
<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->
<body>
<!-- Main Page Container -->
<?php
include ("site/header.php");
?>
    <div class="header-breadcrumbs">
      <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="resources.php">Resources</a></li>
        <li><a href="glossary.php">Glossary</a></li>
      </ul>
    </div>
  </div>
  <div class="main">
    <div class="main-navigation">
      <div class="round-border-topright"></div>
      <!-- Title -->
      <h1 class="first">Client Name News</h1>
      <?php
include ("site/news.php");
?>
      <?php
include ("site/affiliations.php");
?>
<?php
include ("site/rss.php");
?>
<?php
include ("site/more.php");
?>
</div>
    <div class="main-content">
      <h1 align="right" class="pagetitle">Client Page Title</h1>
<?php
//USER SEARCH
if (($_POST['submit']) || ($_POST['searched_term']))
{
	show_aTozList();
	
	//set query type
	$qry_type =3;
	
	//set term
	$term = trim($_POST[searched_term]);
	
	show_matches($qry_type, $term);
}
else
{
	//Get the requested URL
	$url = $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
	//Determine the query type based on parsed url length
	$url_length = strlen($url);
	$type_pos = strrpos($url, "?Q=") + 3;
	//Get the letter clicked
	$search_request = substr($url, $type_pos);
	//make sure it is lowercase
	$term = strtolower($search_request);
	
	$qry_type = strlen($search_request);
	
	show_aTozList();
	
	//Sets the query type based on the URLs length
	// if it is one, it was a letter query
	if ($qry_type ==1)
	{
		show_matches($qry_type, $term);
	}
	else
	{
		//if it was anything else, then show everything
		$term=NULL;
		$qry_type=2;
		show_matches($qry_type, $term);
	}
}

function show_matches($type, $string)
{
	//Our Three Different Query Types
	$qry_letter = "SELECT id, term, definition FROM definitions WHERE term LIKE '".$string."%' ORDER BY term";
	$qry_search = "SELECT id, term, definition FROM definitions WHERE term LIKE '%".$string."%' ORDER BY term";
	$qry_all = "SELECT id, term, definition FROM definitions ORDER BY term";
	
	//Open Database
	include ("site/include.php");
	$link = mysql_connect ($h, $un, $p);
	$database = mysql_select_db($db);
	
	//if the database is opened
	if($database)
	{
		//Set-up the resulting rows based on query requested
		//Clicked on Letter
		if ($type == 1)
		{
			$result_set = mysql_query($qry_letter);
			//If the search returned at least 1 match
			if(mysql_num_rows($result_set) > 0)
			{
				//The Search was successful
				echo "<h2 style='color:green'>Your search returned: </h2>";
			}
			//If the search did not return any results
			else
			{
				echo "<h2 style='color:red'>No records matched your search</h2>";
				echo "<p> Below is a list of all definitions in our database</p>";
				$result_set = mysql_query($qry_all);
			}
		}
		//Used search box
		elseif($type == 3)
		{
			$result_set = mysql_query($qry_search);
			if(mysql_num_rows($result_set) > 0)
			{
				echo "<h2 style='color:green'>Your search returned: </h2>";
			}
			else
			{
				echo "<h2 style='color:red'>No records matched your search for: " .ucwords($string)."</h2>";
				echo "<p> Below is a list of all definitions in our database</p>";
				$result_set = mysql_query($qry_all);
			}
		}
		//Anything else
		else
		{
			$result_set = mysql_query($qry_all);
		}
		
		//Print out the result set
		echo "<div class='glossary'><dl>";
		while ($record = mysql_fetch_row ($result_set))
		{
			echo "<dt>".ucwords($record[1])."</dt>";
			echo "<dd>".$record[2]."</dd>";
 		}
		echo "</dl></div>";	
	}
	//If the database had an error show error
	//do not display mysql error becuase it tells
	//the outside world something about yoru server -- that is a no no
	else 
	{
		echo "<p>There was an error opening the database</p>";	
	}
}

function show_aTozList()
{
      echo "<div class='column1-unit'><div class='aToz'>
      		<ul>
        		<li><a href='glossary.php?Q=a'>A</a></li>
        		<li><a href='glossary.php?Q=b'>B</a></li>
        		<li><a href='glossary.php?Q=c'>C</a></li>
        		<li><a href='glossary.php?Q=d'>D</a></li>
        		<li><a href='glossary.php?Q=e'>E</a></li>
        		<li><a href='glossary.php?Q=f'>F</a></li>
        		<li><a href='glossary.php?Q=g'>G</a></li>
        		<li><a href='glossary.php?Q=h'>H</a></li>
        		<li><a href='glossary.php?Q=i'>I</a></li>
		        <li><a href='glossary.php?Q=j'>J</a></li>
       			<li><a href='glossary.php?Q=k'>K</a></li>
		        <li><a href='glossary.php?Q=l'>L</a></li>
		        <li><a href='glossary.php?Q=m'>M</a></li>
		        <li><a href='glossary.php?Q=n'>N</a></li>
		        <li><a href='glossary.php?Q=o'>O</a></li>
		        <li><a href='glossary.php?Q=p'>P</a></li>
		        <li><a href='glossary.php?Q=q'>Q</a></li>
		        <li><a href='glossary.php?Q=r'>R</a></li>
		        <li><a href='glossary.php?Q=s'>S</a></li>
		        <li><a href='glossary.php?Q=t'>T</a></li>
		        <li><a href='glossary.php?Q=u'>U</a></li>
		        <li><a href='glossary.php?Q=v'>V</a></li>
		        <li><a href='glossary.php?Q=w'>W</a></li>
		        <li><a href='glossary.php?Q=x'>X</a></li>
		        <li><a href='glossary.php?Q=y'>Y</a></li>
		        <li><a href='glossary.php?Q=z'>Z</a></li>
		      </ul>
      		</div>";
}

?> 
      </div><!--Ends column-1 unit-->
</div>
  <!-- RIGHT COLUMN-->
  <div class="main-subcontent">
    <div class="subcontent-unit-border">
		<div class="round-border-topleft"/></div>
		<div class="round-border-topright"/></div>
		<h1 class="white">Search</h1>
        <p>&nbsp;</p>
		<div class="searchform">
			<form method="post" action="glossary.php">
			<fieldset>
			<p>
			  <input class="searched_term" value=" Search..." name="searched_term"/>
			  <input class="button" type="submit" value="GO!" name="submit"/>
		    </p>
			</fieldset>
			</form>
            <p>&nbsp;</p>
		</div>
	</div>
  </div>
</div>
<?php
include ("site/footer.php");
?>
</body>
</html>
