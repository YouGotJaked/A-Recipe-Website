<?php
require_once __DIR__."/../root.php";
require_once DIR_SRC."view.php";

class RecipeIngredientView extends View {
  public function __construct() {
    parent::__construct("recipe_ingredient_vw");
  }

  public function display($id) {
    $select = $this->select(["recipe_id" => $id], "i");
    $recipe_ingr_obj = json_decode($select);

    $html = '<div class="ingredients"><div class="ingredients inner">';
    $html .= '<p id = "ing">Ingredients</p><ul>';
    
    foreach($recipe_ingr_obj as $ingr) {
      //echo "- " . $ingr->amount . " " . $ingr->ingredient . "<br>";
      $html .= '<li><input type = "checkbox" id = "ingredients">'.$ingr->amount.' '.$ingr->ingredient.'</li><br/>';
    }

    $html .= '</ul></div></div>';
    echo $html;
  }
}
?>
