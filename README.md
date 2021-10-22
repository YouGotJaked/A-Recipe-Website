# Homemade
A website for hosting and sharing recipes.
## Description
Homemade is a website design to act as a digital cookbook. You along with our tight-knit community can submit, share, and favorite recipes. A live version can be accessed on the [SCU engineering website](https://ssl.students.engr.scu.edu/~jday/MSIS-2630/A-Recipe-Website).
### Directory Descriptions
The root directory contains a few files besides this README. The most notable are `index.php`, a simple placeholder page which directs users to the login page, and `root.php`, a file containing a list of defined constants.
#### admin
This directory contains PHP scripts relating to database configuration. Here you can quickly perform SQL operations like selecting, inserting, altering, updating, and deleting tables and views. Note that only the `create` and `insert` subdirectories need to be used. The other subdirectories were created and used as needed during development.
#### css
This directory contains custom styling and locally-installed fonts.
#### img
This directory contains image assets.
#### js
This directory contains all JavaScript functionality.
#### local
This directory contains your database configuration file.
#### src
This directory contains majority of the back-end functionality. 
#### test
This directory contains various test scripts for testing different website functionality.
#### web
This directory contains the web-facing pages that users will actually see when they visit the page.
## Setup
### Prerequisites
PHP version 7.2.24 or later.

MariaDB 5.5.68 or later.
### Database
#### Configuration
To connect this website with your database, you will need to create a local configuration file on your server. Navigate to the `/local` subdirectory and create a file called `config.ini`. Open this file in a text editor and insert the following information:

```
[database]
host = "<server name>"
user = "<database username>"
pass = "<database password>"
name = "<database>"
```

Save this file and run the test script under `test/database_test.php` to verify you can connect to the database.
#### Creation
Once you confirm connection to your database, you will need to create the tables, views, and insert some preliminary values. Navigate to the `admin/create/table` subdirectory. Run the PHP scripts in the following order:
1. `create_user_table.php`
2. `create_recipe_table.php`
3. `create_favorite_table.php`
4. `create_ingredient_table.php`
5. `create_tag_table.php`
6. `create_recipe_category_table.php`
7. `create_recipe_ingredient_table.php`
8. `create_recipe_instruction_table.php`
9. `create_recipe_tag_table.php`

Now, navigate to the sibling `admin/create/view` directory and run the PHP scripts in the following order:
1. `create_recipe_view.php`
2. `create_favorite_view.php`
3. `create_recipe_ingredient_view.php`
4. `create_recipe_instruction_view.php`
5. `create_recipe_tag_view.php`

Lastly, we will need to insert some preliminary values. Navigate to the `admin/insert` subdirectory and run the following PHP scripts (order does not matter):
1. `insert_recipe_category_values.php`
2. `insert_tag_values.php`
## Usage
### Security
#### Access Restrictions
Depending on your server configuration, you may need to set up a `.htaccess` file in the root directory to prevent nefarious users from accessing restricted parts of your website. Create a `.htaccess` file in your root directory and insert the following information:

```
RewriteEngine On
# redirect protected subdirectories to login page
RewriteCond %{REQUEST_METHOD} !POST
RewriteRule ^(admin|local|src|test)/(.*)$ web/login.php [L,NC,R=302;SameSite=Strict;Secure]
# can't disable index browsing, so hide files
IndexIgnore *
```

**NOTE**: You should only create this file after running the database setup scripts in the `/admin` subdirectory, as you won't be able to access them after creating this file. However, if you need to make any changes you can temporarily comment on the rewrite rules (not recommended).
#### Sessions
As an additional security measure, sessions are limited to one hour in length. If you leave the website and return within the hour, you will be redirected to the home page under your account. If over an hour has passed, you will be redirected to the login page and asked to sign in again. 
### Login
Upon first accessing the website, you will be redirected to the login page. Here, you can log into your account if you have one. If not, you can click on the link to create an account.
### Signup
To sign up for an account, you need to provide a few pieces of information: your email address (must be unique), first and last name, and a password.
### Homepage
Upon logging in or signing up for an account, you will be redirected to the home page. This page displays a welcome greeting as well as a randomly-picked recipe to display.
### Search
A search bar is included in the top header. You can search for recipes by recipe title keywords. For example, searching for `banana` would return `Blueberry Banana Baked Oatmeal`. 
### Recipes
This page displays the entire catalog of recipes created by our users. It is divided into categories for easier navigation.
### Favorites
This page displays the current user's favorited recipes. If the user does not have any favorited recipes, a message will be displayed prompting them to browse the full recipe catalog for inspiration.
### Recipe
This page displays all information related to a specific recipe. It displays the recipe name up top, along with a golden star. The star allows a user to either favorite (if filled in) or unfavorite (not filled in) the recipe. Below the recipe name is a list of optional recipe tags. Hovering over these tags will give a more descriptive explanation of the tag. Next, the serving size and category are displayed below that.

The middle section includes a list of ingredients. Each ingredient has an optional quantity and unit of measurement. Also, there is a checkbox next to each ingredient to allow users to mark ingredients they have on hand when making this recipe.

Lastly, the bottom section contains the ordered list of instructions. 
### Add a Recipe
This page allows users to submit a recipe. It contains the following fields:
- Recipe name (required)
- Serving size (required, defaults to `4`)
- Category (required, defaults to `Appetizer`)
- Tags (optional, can select multiple)
- Ingredients (required, can add and remove to list)
- Instructions (required, can add and remove to list)

Upon clicking the submit recipe button, the user is taken to the newly created recipe page.
### Logout
Clicking on the logout link in the top header will end the current user's session and redirect them to the login page.
## Future Considerations
In order to avoid scope creep, we had to eliminate many potential features in order to get our MVP to market on time. These are some of the features we would like to add going forward:
- Recipe images: users will be able to submit images either during recipe submission or when visiting a pre-existing recipe page.
- Account types: include different account types like `user`, `moderator`, and `admin` to enable varying functionality for different users.
- Content moderation: have recipe submissions go through a content moderation queue to uphold the recipe quality expectation.
- Reviews/notes: enable the option for users to leave reviews/notes on recipes. 
- Variable serving size: adjust the serving size of a given recipe to scale up or down ingredient quantities.
- Search: enable recipe matching when typing in the search bar, allow for searching by other attributes like category, tags, and ingredients.
- Forgot your password: enable ability to reset your password if forgotten.
- Shopping list: create a grocery shopping list and find recipes you can make with those ingredients.