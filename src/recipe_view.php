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
    echo '<h3>'.$recipe_obj->name.'</h3>';
    $recipe_tag_vw->display($id);
    
    $ul = '<ul>';
    $ul .= '<li>Serving Size: '.$recipe_obj->serving_size.'</li>';
    $ul .= '<ll>Category: '.$recipe_obj->category.'</li>';
    $ul .= '</ul>';
    echo $ul;

    $recipe_ingr_vw->display($id);
    $recipe_instr_vw->display($id);
  }
}
?>
