<?php
require_once __DIR__."/../root.php";
require_once DIR_SRC."view.php";
require_once DIR_SRC."recipe_tag_view.php";
require_once DIR_SRC."recipe_ingredient_view.php";
require_once DIR_SRC."recipe_instruction_view.php";

class RecipeView extends View {
  public function __construct($view="recipe_vw") {
    parent::__construct($view);
  }
  
  public function display($id) {
    // TODO: should this be a class property?
    $select = $this->select(["recipe_id" => $id], "i");
    $recipe_obj = json_decode($select)[0];
    
    // get recipe tags, ingredients, and instructions
    $recipe_tag_vw = new RecipeTagView();
    $recipe_ingr_vw = new RecipeIngredientView();
    $recipe_instr_vw = new RecipeInstructionView();

    // display recipe information
    echo '<div class="recipeContainer"><h1 id="recipeTitle" recipe-id="'.$recipe_obj->recipe_id.'">'.$recipe_obj->name.'</h1>';
    echo '<a id="favoriteStar" href="#" action="'.LINK_SRC.'user_favorite.php" fav="0">&#9734</a></div>';
    $recipe_tag_vw->display($id);
    
    $ul = '<ul>';
    $ul .= '<li><p id = "serving"><b>Serving Size:</b> '.$recipe_obj->serving_size.'</p></li>';
    $ul .= '<ll><p id = "serving"><b>Category:</b> '.$recipe_obj->category.'</p></li>';
    $ul .= '</ul>';
    echo $ul;

    echo '<hr/>';
    $recipe_ingr_vw->display($id);
    echo '<hr/>';
    $recipe_instr_vw->display($id);
  }
}
?>
