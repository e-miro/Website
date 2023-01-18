<html>
<head>
<title>Verbosity</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="main">
  <div class="verb-holder">
<h1>Verbosity!</h1>
<p>Here's what I came up with (If I don't know a word, I won't try to change it.):
</p>

<?php
// This is a list of words I want to replace with specific other strings. Sometimes I want them to not be changed by the program.
$filter_words = array(
  'I' => 'I VERILY',
  'ARE' => 'ART',
  'DO' => 'DOTH',
  'YOU' => 'THY',
  'THE' => 'THE',
  'TO' => 'TO',
  'I\'D' => 'I VERILY WOULD',
  'THIS' => 'THISN',
  'WHY' => 'WHEREFORE',
  'DID' => 'DID VERILY',
  'YOURS' => 'THINE',
  'THAT' => 'THAT THUSLY',
  'THERE' => 'THENCE',
  'A' => 'A',
  'IS' => 'IS INDEED',
  'I\'M' => 'I AM',
  'IT' => 'IT',
  'DON\'T' => 'DO NOT',
  'WON\'T' => 'WILL NOT',
  'CAN\'T' => 'CANNOT'
);

$sentence = array();

if(isset($_REQUEST['input'])){
  $words = explode(" ", $_REQUEST['input']);
  // This swaps out each word the user puts in for a synonym. Doesn't handle homophones well. Will have to fix that if possible.
  foreach($words as $value){
    $value = strtoupper($value);
    if(has_nums($value)){
      array_push($sentence, $value);
    }elseif(array_key_exists($value, $filter_words)){
      array_push($sentence, $filter_words[$value]);
    }
    else{
        array_push($sentence, replace_word($value));      
    }
  }
  ?>
  <p>
    <?php
  foreach($sentence as $value){
    echo " ";
    echo $value;
  }
    echo ".";
  ?>
  </p>
  <?php

}else{
  echo "No input received from previous page. I hope that's not a problem.";
}
?>

<?php

  // This makes sure program behaves itself with numbers.
  function has_nums($word){
    $digits = array(1,2,3,4,5,6,7,8,9,0);
    foreach($digits as $digit){
      if(str_contains($word, $digit)){
        return true;
      }
    }
  return false;
  }


  // This will swap each word for a new one. If possible.
  function replace_word ($word){
    // Sets up required fields for the API query, then executes query.
  $ref='thesaurus';
  $key='69992a1e-1922-47f6-ab06-ac7c7bcf3d89';

  $result=(grab_json_definition($word, $ref, $key));

  // Works its way through the JSON file to get to the bit I want. 
  // Should look to clean this up if possible.
  // Checks at each step whether next step is possible. This is important
  // as the Mirriam Webster API return can be unpredictable.
    $decoded = json_decode($result, true);
    if(isset($decoded[0])){
      $nextLayer = $decoded[0];
      if(isset($nextLayer['meta'])){
        $meta = $nextLayer['meta'];
        if(isset($meta['syns'])){
          $syns = $meta['syns'];
          if(isset($syns[0])){
            $synonyms = $syns[0];
            $keys = array_keys($synonyms); 
          }else{
            return $word;
          }
        }else{
          return $word;
        }
      }else{
        return $word;
      }
    }else{
      return $word;
    }
    

  // Chooses the longest word, then sets it as the replacement.
  $current_max = strlen($word);
  $current_word = $word;

    foreach($keys as $newvalue){

    if(str_contains($synonyms[$newvalue], ' ')){

    }else{
      $length = strlen($synonyms[$newvalue]);
        if($length>$current_max){
      $current_max = $length;
      $current_word = $synonyms[$newvalue];
        }
      }
    }
  return strtoupper($current_word);
  }

  // This function grabs the thresaurus information about a word in JSON format. The JSON file is a nightmare to parse. API from mirriam webster.
  function grab_json_definition ($word, $ref, $key) {
    $uri = "https://dictionaryapi.com/api/v3/references/" . urlencode($ref) . "/json/" . urlencode($word) . "?key=" . urlencode($key);

    return file_get_contents($uri);
  };

  $jdef = grab_json_definition("test", "thesaurus", "69992a1e-1922-47f6-ab06-ac7c7bcf3d89");

?>
  <a href="verbosity.php"><img class="icon" src="res/return.png" alt="Link to verbosity main page."></a>
  </div>
  </div>
</body>
</html>