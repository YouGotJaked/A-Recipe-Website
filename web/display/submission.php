<?php
// constants
require_once __DIR__."/../../root.php";

// requirements
require_once DIR_SRC."submission.php";
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
$title = "Submission - Homemade";
$buffer = preg_replace('/(<title>)(.*?)(<\/title>)/i', '$1' . $title . '$3', $buffer);
echo $buffer;

// when user clicks submit button
if (isset($_POST["submit"])) {
  submit_recipe();
}
?>
<div class="recipe_sub_container">
  <p id="recipe_sub_form">Recipe Submission Form</p>
  <form method="POST" action="submission.php">
    <ul class="form-wrapper">
      <li class="form-row recipe-name">  
        <label for="recipeName">Recipe Name</label>
        <input type="text" id="recipeName" name="recipeName" placeholder="Pasta Primavera" required>
      </li>
      <li class="form-row serving-size">
        <label for="servingSize">Serving Size</label>
        <output>4</output>
        <input type="range" name="servingSize" min="1" max="16" value="4" onInput="this.previousElementSibling.value = this.value" required>
      </li>
      <li class="form-row category">
        <label for="category">Category</label>
        <select name="category" required><?=get_category_options()?></select>
      </li>
      <li class="form-row tags">
        <label for="tag">Tags</label>
        <select name="tag[]" multiple><?=get_tag_options()?></select>
      </li>
      <li class="form-row ingredients">
        <label for="ingredients">Ingredients</label>
        <div class="form-row sub ingr" index="0">
          <input type="text" name="ingredients[]" placeholder="16 oz penne pasta" required>
          <input type="button" id="addIngredient" input-name="ingredients[]" value="+" onclick="addInput(this.id)">
        </div>
      </li>
      <li class="form-row instructions">
        <label for="instructions">Instructions</label>
          <div class="form-row sub inst" index="0">
            <input type="text" name="instructions[]" placeholder="In a medium pot over high heat, bring salted water to a boil..." required>
          <input type="button" id="addInstruction" input-name="instructions[]" value="+" onclick="addInput(this.id)">
        </div>
      </li>
      <li class="form-row submit">
        <input id="addRecipe" type="submit" name="submit" value="Submit">
        <!--button type="submit" name="submit">Submit</button-->
      </li>
    </ul>
  </form>
</div>
<script>
function addInput(btnId) {
  const btn = document.getElementById(btnId);
  const input = btn.previousSibling;
  const formRowSub = btn.parentNode;
  const newFormRowSub = formRowSub.cloneNode(true);
  const newInput = newFormRowSub.getElementsByTagName("input")[0];

  let index = newFormRowSub.getAttribute("index");
  newFormRowSub.setAttribute("index", parseInt(index) + 1);
  newInput.value = "";
  newInput.removeAttribute("placeholder");

  if (btnId.startsWith("add")) {
    btn.setAttribute("id", "removeIngredient");
    btn.setAttribute("value", "-");
    btn.removeAttribute("onclick");
    btn.onclick = () => removeInput(formRowSub.className, formRowSub.getAttribute("index"));
    insertAfter(newFormRowSub, formRowSub);
  }
}

function removeInput(cls, index) {
  document.querySelectorAll('[class="'+cls+'"][index="'+index+'"]')[0].remove();
}
</script>
<?php require_once DIR_SRC."footer.php"; ?>
