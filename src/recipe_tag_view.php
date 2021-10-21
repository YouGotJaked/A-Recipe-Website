<?php
require_once __DIR__."/../root.php";
require_once DIR_SRC."view.php";

class RecipeTagView extends View {
  public function __construct() {
    parent::__construct("recipe_tag_vw");
  }

  public function display($id) {
    $select = $this->select(["recipe_id" => $id], "i");

    if (!$select) {
      return;
    }

    $recipe_tag_obj = json_decode($select);

    $html = '<div class="tags"><ul>';
    
    foreach($recipe_tag_obj as $tag) {
      #$html .= '<li>'.$tag->descr_short.'</li>';
      $html .= '<li><div class="tooltip">'.$tag->descr_short;
      $html .= '<span class="tooltiptext">'.$tag->descr.'</span>';
      $html .= '</div></li>';
    }

    $html .= '</ul></div>';
    echo $html;
  }
}
?>
