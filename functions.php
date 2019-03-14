<?php

$author = 'Tucker Tavarone';
$nav_color = '#4285f4';
$nav_text_color = '#f3e0dc';
$pages = array ('index.php' => 'Home',
				'noms.php' => 'Noms',
				'adjectifs.php' => 'Adjectifs',
				'verbs.php' => 'Verbs');

function make_lists($page_name) {

  $page_name = lcfirst($page_name);
  $file = file('verbs.csv');
  


  foreach($file as $line) {
    
    $arr = explode(',', $line);
    
    /* This creates an array called record
      Where the verb type is the array index
      $arr[0] is the verb en francais
      $arr[1] is the verb en anglais
      $arr[2] is the verb TYPE
      */
      

    $word['french'] = $arr[0];
    $word['english'] = $arr[1];
    
    $record[$arr[2]][] = $word;
  }
  
  ksort($record);

  $list = '<div class="row">';
    foreach ($record as $type=>$wordlist) {
    $type = trim($type);
    $list .= '<div class="col-md-3"><h2>'.$type.'</h2><ul class="list-group list-group-flush">';
        foreach ($wordlist as $w) {
          $list .= '<li class="list-group-item">'.$w['french'].' = '.$w['english'].'</li>';
        }
      $list .= '</ul></div>';
    }  
  $list .= '</div>';

  return $list;
}

function make_navbar() {
  global $pages;
  global $author;
  global $nav_color;
  global $nav_text_color;
  
  $menu_item = '';
  
  foreach ($pages as $link => $name) {
    $menu_item .= '<a class="nav-link active" href="'.$link.'" style="color: '.$nav_text_color.'">'.$name.'</a>';
  }
  
  return '
        <header style="background-color: '.$nav_color.'">
          <!-- website navbar -->
          <nav class="navbar navbar-expand-md navbar-dark" style="background-color: '.$nav_color.'">
            <a class="navbar-brand" href="index.html" style="color: '.$nav_text_color.'">'.$author.'</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainnav" 
                          aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon" style="background-color: '.$nav_color.'"></span>
            </button>
            <div class="collapse navbar-collapse" id="mainnav">
              <div class="navbar-nav" >
                '.$menu_item.'
              </div>
            </div>
          </nav>
        </header>';
  }

  function make_footer() {
    global $pages;
    global $author;
    global $nav_color;

    $menu_item = '';

    foreach ( $pages as $link => $name) {
      $menu_item .= '<a href="'.$link.'" style="color: '.$nav_color.'">'.$name.'</a>';
    }

    return '
    <footer>
      &copy; 2019 '.$author.'
        <nav>
          '.$menu_item.'
        </nav>
    </footer>';
  }

function make_top($page_name, $ext_fonts = null, $style = null) {
  global $author;

  if ($style != null) {
    $style = '<style>'.file_get_contents($style).'</style>';
  }

  if ($ext_fonts != null) {
    $ext_fonts = file_get_contents(__DIR__ . '/assets/googleFonts');
  }

  return '
    <!DOCTYPE html>
    <html lang="en">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    '.$ext_fonts.'
    <head>
      <title>'.$author.' | '.$page_name.'</title>
      <style type="text/css">
        '.$style.'
      </style>
    </head>
    <body>';
}

function getDoc($page_name){


  return '
     var docRef = db.collection("noms").doc("animals");
        docRef.get().then(function(doc) {
            if (doc.exists) {
                console.log("Document data:", doc.data());
            } else {
                // doc.data() will be undefined in this case
                console.log("No such document!");
            }
        }).catch(function(error) {
            console.log("Error getting document:", error);
        });';
}

function make_bottom($page_name, $javascript = null) {
  $page_name = lcfirst($page_name);
  return '
      <!-- javascript -->
      
      <style>'.$javascript.'</style>
      <script src="https://www.gstatic.com/firebasejs/5.8.6/firebase.js"></script>
      <script>
        // Initialize Firebase
        var config = {
          apiKey: "AIzaSyB9jKIr-UzqipbZAlUqeYAvXbn1bb0Om18",
          authDomain: "italianwebsite-7acd0.firebaseapp.com",
          databaseURL: "https://italianwebsite-7acd0.firebaseio.com",
          projectId: "italianwebsite-7acd0",
          storageBucket: "italianwebsite-7acd0.appspot.com",
          messagingSenderId: "922833067039"
        };
        firebase.initializeApp(config);
        var rootRef = firebase.database().ref();

        var db = firebase.firestore();

        var docRef = db.collection("verbs").doc("er");
        docRef.get().then(function(doc) {
            if (doc.exists) {
                console.log("Document data:", doc.data());
            } else {
                // doc.data() will be undefined in this case
                console.log("No such document!");
            }
        }).catch(function(error) {
            console.log("Error getting document:", error);
        });
      </script>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
    </body>
    </html>
  ';
}

function make_page($page_name, $page_content){
	global $pages;
	global $author;
  $list = '';
  //should make only the verbs page with a list

  if($page_name == 'Verbs') {
    $list = make_lists($page_name);
  }

	echo make_top($page_name, null, null);
	echo make_navbar();

	echo '<main class="container">';
	echo file_get_contents($page_content);
  echo $list;
	echo '</main>';

	echo make_footer();
	echo make_bottom($page_name, null);
}
?>