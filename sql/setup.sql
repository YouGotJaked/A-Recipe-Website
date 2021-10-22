-- create user table
CREATE TABLE IF NOT EXISTS `user` (
`user_id` int(11) NOT NULL AUTO_INCREMENT,
`first_name` varchar(255) DEFAULT NULL,
`last_name` varchar(255) DEFAULT NULL,
`email` varchar(255) NOT NULL UNIQUE,
`password_hash` char(60) NOT NULL,
PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=37;

-- create recipe table
CREATE TABLE IF NOT EXISTS `recipe` (
`recipe_id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL,
`serving_size` int(11) NOT NULL,
`recipe_category_id` int(11) NOT NULL,
PRIMARY KEY (`recipe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=63;

-- create favorite table
CREATE TABLE IF NOT EXISTS `favorite` (
`favorite_id` int(11) NOT NULL AUTO_INCREMENT,
`recipe_id` int(11) NOT NULL,
`user_id` int(11) NOT NULL,
PRIMARY KEY (`favorite_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=19;

-- create ingredient table
CREATE TABLE IF NOT EXISTS `ingredient` (
`ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
`name` varchar(255) NOT NULL UNIQUE,
PRIMARY KEY (`ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=18;

-- create tag table
CREATE TABLE IF NOT EXISTS `tag` (
`tag_id` int(11) NOT NULL AUTO_INCREMENT,
`descr` varchar(255) NOT NULL,
`descr_short` varchar(4) NOT NULL,
PRIMARY KEY (`tag_id`),
CONSTRAINT uc_descr UNIQUE (`descr`, `descr_short`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=48;

-- create recipe category table
CREATE TABLE IF NOT EXISTS `recipe_category` (
`recipe_category_id` int(11) NOT NULL AUTO_INCREMENT,
`category` varchar(255) NOT NULL UNIQUE,
PRIMARY KEY (`recipe_category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=24;

-- create recipe ingredient table
CREATE TABLE IF NOT EXISTS `recipe_ingredient` (
`recipe_ingredient_id` int(11) NOT NULL AUTO_INCREMENT,
`recipe_id` int(11) NOT NULL,
`ingredient_id` int(11) NOT NULL,
`amount` varchar(255) DEFAULT NULL,
PRIMARY KEY (`recipe_ingredient_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=7;

-- create recipe instruction table
CREATE TABLE IF NOT EXISTS `recipe_instruction` (
`recipe_instruction_id` int(11) NOT NULL AUTO_INCREMENT,
`recipe_id` int(11) NOT NULL,
`step` varchar(255) NOT NULL,
`step_index` int(11) NOT NULL,
PRIMARY KEY (`recipe_instruction_id`),
CONSTRAINT uc_recipe_step_index UNIQUE (`recipe_id`, `step_index`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=9;

-- create recipe tag table
CREATE TABLE IF NOT EXISTS `recipe_tag` (
`recipe_tag_id` int(11) NOT NULL AUTO_INCREMENT,
`recipe_id` int(11) NOT NULL,
`tag_id` int(11) NOT NULL,
PRIMARY KEY (`recipe_tag_id`),
CONSTRAINT uc_recipe_tag UNIQUE (`recipe_id`, `tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=48;

-- create recipe view
CREATE VIEW `recipe_vw` AS 
SELECT r.recipe_id
, r.name
, r.serving_size
, rc.category
FROM recipe r 
JOIN recipe_category rc
ON r.recipe_category_id=rc.recipe_category_id
ORDER BY rc.category, r.name;

-- create favorite view
CREATE VIEW `favorite_recipe_vw` AS 
SELECT rv.recipe_id
, rv.name
, rv.serving_size
, rv.category
, f.favorite_id
, u.user_id
, u.first_name
, u.last_name
, u.email
FROM recipe_vw rv 
JOIN favorite f 
ON rv.recipe_id=f.recipe_id 
JOIN user u 
ON u.user_id=f.user_id 
ORDER BY rv.category, rv.name;

-- create recipe ingredient view
CREATE VIEW `recipe_ingredient_vw` AS 
SELECT r.recipe_id
, r.name AS `recipe`
, i.name AS `ingredient`
, rig.amount
FROM recipe r 
JOIN recipe_ingredient rig
ON r.recipe_id=rig.recipe_id
JOIN ingredient i
ON i.ingredient_id=rig.ingredient_id
ORDER BY r.name;

-- create recipe instruction view
CREATE VIEW `recipe_instruction_vw` AS 
SELECT r.recipe_id
, r.name AS `recipe`
, rin.step
, rin.step_index
FROM recipe r 
JOIN recipe_instruction rin
ON r.recipe_id=rin.recipe_id
ORDER BY r.name, rin.step_index;

-- create recipe tag view
CREATE VIEW `recipe_tag_vw` AS 
SELECT r.recipe_id
, r.name
, t.descr
, t.descr_short
FROM recipe r 
JOIN recipe_tag rt
ON r.recipe_id=rt.recipe_id
JOIN tag t
ON t.tag_id=rt.tag_id
ORDER BY r.name, t.descr;

-- insert recipe category values
INSERT INTO recipe_category (category)
VALUES ('Breakfast')
, ('Beverage')
, ('Lunch')
, ('Appetizer')
, ('Soup')
, ('Salad')
, ('Bread')
, ('Beef')
, ('Poultry')
, ('Pork')
, ('Seafood')
, ('Vegetarian/Vegan')
, ('Dessert')
, ('Miscellaneous');

-- insert tag values
INSERT INTO tag (descr, descr_short)
VALUES ('Meal Prep Friendly', 'MPF')
, ('Quick and Easy', 'Q&E')
, ('Healthy', 'H')
, ('Keto', 'K')
, ('Pescetarian', 'P')
, ('Vegetarian', 'V')
, ('Vegan', 'VE');