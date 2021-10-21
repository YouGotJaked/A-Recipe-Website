<?php
require_once __DIR__."/../root.php";
require_once DIR_SRC."view.php";

class RecipeInstructionView extends View {
  public function __construct() {
    parent::__construct("recipe_instruction_vw");
  }
  
  public function display($id) {
    $select = $this->select(["recipe_id" => $id], "i");
    $recipe_instr_obj = json_decode($select);

    $html = '<div class="instructions"><div class="instructions inner">';
    $html .= '<p id = "ing">Instructions</p><ol>';
    
    foreach($recipe_instr_obj as $instr) {
      //echo $instr->step_index+1 . "). " . $instr->step . "<br>";
      $html .= '<li>'.($instr->step_index+1).') '.$instr->step.'</li><br/>';
    }

    $html .= '</ol></div></div>';
    echo $html;
  }
}
?>
