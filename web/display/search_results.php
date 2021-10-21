<?php
// constants
require_once __DIR__."/../../root.php";

// requirements
require_once DIR_SRC."recipe_view.php";
session_start();

// verify user is logged in
if (!isset($_SESSION["login"])) {
  header("Location: ".LINK_WEB."login.php");
}

// header
ob_start();
require_once DIR_SRC."header.php";
$buffer = ob_get_contents();
ob_end_clean();
$title = "Search - Homemade";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;
    

$keyword = $_GET["keyword"]; //from search bar form

//Make connection to the database
#require_once('mysqli_connect.php'); //connection file

// Make user search query
#$display_query = "SELECT * FROM recipe WHERE name LIKE '%$keyword%'";
// get all recipes
$recipe_vw = new RecipeView();
$select = $recipe_vw->select_search(["name" => "%".$keyword."%"], "s");
$recipe_obj = json_decode($select);

// Run the search query
#$result_displayq = mysqli_query ($dbc, $display_query);
#$result_displaycheck = mysqli_num_rows($result_displayq);
#$row = mysqli_fetch_all($result_displayq,MYSQLI_ASSOC);
?>
<div class = "search_results">
  <!--p style = "padding-top: 90px; padding-left: 100px; font-family: Avenir; font-size: 18px; font-weight: bold;">SEARCH RESULTS</p-->
  <p style = "padding-top: 90px; padding-left: 100px; font-size: 18px; font-weight: bold;">SEARCH RESULTS</p>
  <hr class="hr_search">
  <style>
    li.result{
      display: block;
      /*font-family: Avenir;*/
	    padding-left: 110px;
	    padding-top: 10px;
      font-weight: bold;
    }
  </style>
  <ul>
  <?php
  // Display database information if search returns a result
  if (!empty($recipe_obj)) {
    foreach ($recipe_obj as $recipe) {
      #echo '<ul>';
      echo '<li class="result"><a href="'.LINK_WEB.'display/recipe.php?id='.$recipe->recipe_id.'" target="_blank">'.$recipe->name.'</a></li>'; // Link to recipe?
      #echo '</ul>';
    }
  } else {
    #echo '<ul>';
    echo '<li class = "result">No recipes matched your search. Please try again.</li>';
    #echo '</ul>';
  }
  echo '</ul>';
  // Close the database connection
  #mysqli_close($dbc); 
  ?>              
  </ul>
</div>
<?php require_once DIR_SRC."footer.php"; ?>
