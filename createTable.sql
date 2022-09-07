CREATE TABLE Users (
ID		INTEGER	PRIMARY KEY,
PostalCode  VARCHAR2(30),
City 		VARCHAR2(15),
Country 	VARCHAR2(30),
Email 		VARCHAR2(40),
Province 	VARCHAR2(30));

CREATE TABLE Visitor (
ID			    INTEGER,
TemporaryID		INTEGER,	
PRIMARY KEY (ID),
FOREIGN KEY (ID) REFERENCES Users);

CREATE TABLE Member(
ID			INTEGER,
MemberName	VARCHAR2(30),
PRIMARY KEY (ID),
FOREIGN KEY (ID) REFERENCES Users);

CREATE TABLE Recipe(
RecipeID	 INTEGER,
UserName	 VARCHAR2(30), 
RecipeName	 VARCHAR2(15), 
Difficulty	 INTEGER, 
Instruction	 VARCHAR2(300),
Time	 	 INTEGER,
PRIMARY KEY (RecipeID));

CREATE TABLE View (
ID			    INTEGER,
RecipeID		INTEGER,
PRIMARY KEY (ID, RecipeID),
FOREIGN KEY (ID) REFERENCES Users,
FOREIGN KEY (RecipeID) REFERENCES Recipe);

CREATE TABLE Recipe_Post(
RecipeID 		INTEGER,
ID			INTEGER,
PRIMARY KEY (RecipeID),
FOREIGN KEY (ID) REFERENCES Member);

CREATE TABLE ShoppingList(
ShoppingListName    VARCHAR2(30)  PRIMARY KEY);

CREATE TABLE ShoppingList_Create (
ShoppingListName        VARCHAR2(30),
ID            		    INTEGER,
PRIMARY KEY (ShoppingListName),
FOREIGN KEY (ID) REFERENCES Member,
UNIQUE (ID));

CREATE TABLE Favorite(
CollectionName  VARCHAR2(30)    PRIMARY KEY);
         
CREATE TABLE Ingredients(
IngredientName	VARCHAR2(30) 	PRIMARY KEY,
Weight      		 INTEGER);

CREATE TABLE Allergies(
AllergyName	VARCHAR2(30) 	PRIMARY KEY);

CREATE TABLE Category(
CategoryName  VARCHAR2(30)        PRIMARY KEY);

CREATE TABLE Beverage(
CategoryName       VARCHAR2(30)        PRIMARY KEY,
Alcohol     INTEGER,
FOREIGN KEY (CategoryName) REFERENCES Category);

CREATE TABLE Dessert(
CategoryName    VARCHAR2(30)        PRIMARY KEY,
Keto    		INTEGER,
FOREIGN KEY (CategoryName) REFERENCES Category);

CREATE TABLE Cuisine(
CategoryName       VARCHAR2(30)        PRIMARY KEY,
Region      	    VARCHAR2(30),
FOREIGN KEY (CategoryName) REFERENCES Category);

CREATE TABLE EasyRecipe(
CategoryName       VARCHAR2(30)        PRIMARY KEY,
Time      	       INTEGER,
FOREIGN KEY (CategoryName) REFERENCES Category);

CREATE TABLE Favorite_Add(
CollectionName  VARCHAR2(30),
ID             INTEGER,
PRIMARY KEY (CollectionName),
FOREIGN KEY (ID) REFERENCES Member);

CREATE TABLE Has(
ShoppingListName    VARCHAR2(30),
IngredientName		VARCHAR2(30),
PRIMARY KEY (ShoppingListName, IngredientName),
FOREIGN KEY (ShoppingListName) REFERENCES ShoppingList,
FOREIGN KEY (IngredientName) REFERENCES Ingredients);

CREATE TABLE Includes(
RecipeID      	 INTEGER,
IngredientName	 VARCHAR2(30),
PRIMARY KEY (RecipeID, IngredientName),
FOREIGN KEY (RecipeID) REFERENCES Recipe,
FOREIGN KEY (IngredientName) REFERENCES Ingredients);

CREATE TABLE Belong(
RecipeID      	 INTEGER,
CategoryName	 VARCHAR2(30),
PRIMARY KEY (RecipeID, CategoryName),
FOREIGN KEY (RecipeID) REFERENCES Recipe,
FOREIGN KEY (CategoryName) REFERENCES Category);

CREATE TABLE Label(
RecipeID        	INTEGER,
AllergyName         VARCHAR2(30),
PRIMARY KEY (RecipeID, AllergyName),
FOREIGN KEY (RecipeID) REFERENCES Recipe,
FOREIGN KEY (AllergyName) REFERENCES Allergies);

CREATE TABLE Save(
RecipeID      	 INTEGER,
CollectionName	 VARCHAR2(30),
PRIMARY KEY (RecipeID, CollectionName),
FOREIGN KEY (RecipeID) REFERENCES Recipe ON DELETE CASCADE,
FOREIGN KEY (CollectionName) REFERENCES Favorite);

INSERT INTO Users VALUES(1452,'M2H 9F0','Toronto','Canada','helloworld@gmail.com','Ontario');
INSERT INTO Users VALUES(5647,'G9S 0SD','Toronto','Canada','CPSC304@gmail.com','Ontario');
INSERT INTO Users VALUES(3632,'M2N 0G9','Toronto','Canada','dmp330@gmail.com','Ontario');
INSERT INTO Users VALUES(5200,'V6X 0S4','Richmond','Canada','helloJava@gmail.com','British Columbia');
INSERT INTO Users VALUES(5898,'V7X 1M8','Vancouver','Canada','helloPHP@gmail.com','British Columbia');

INSERT INTO Visitor VALUES(1452,589756);
INSERT INTO Visitor VALUES(5647,412586);
INSERT INTO Visitor VALUES(3632,014759);
INSERT INTO Visitor VALUES(5200,245963);
INSERT INTO Visitor VALUES(5898,154456);

INSERT INTO Member VALUES(1452,'dancing monkey');
INSERT INTO Member VALUES(5647,'anonymous');
INSERT INTO Member VALUES(3632,'arbname');
INSERT INTO Member VALUES(5200,'avengers step parent');
INSERT INTO Member VALUES(5898,'captain canada');

INSERT INTO Recipe VALUES(123456789, 'dancing monkey', 'seafood pasta', 4, '1.cook spaghetti and seafood 2.add tomato sauce', 60);
INSERT INTO Recipe VALUES(987654321, 'anonymous', 'caesar salad', 2, '1.combine dressing and lettuce', 30);
INSERT INTO Recipe VALUES(134679852, 'arbname', 'avocado toast', 1, '1.mash avocado 2. spread avocado on top of toast', 15);
INSERT INTO Recipe VALUES(794613258, 'avengers step parent', 'milk tea', 2, '1.place the tea leaves in a brewing pot 2.add milk', 30);
INSERT INTO Recipe VALUES(179346820, 'captain canada', 'beef burger', 3, '1.grill beef and burgers', 45);

INSERT INTO View VALUES(1452,123456789);
INSERT INTO View VALUES(5647,987654321);
INSERT INTO View VALUES(3632,134679852);
INSERT INTO View VALUES(5200,794613258);
INSERT INTO View VALUES(5898,179346820);

INSERT INTO Recipe_Post VALUES(123456789,1452);
INSERT INTO Recipe_Post VALUES(987654321,5647);
INSERT INTO Recipe_Post VALUES(134679852,3632);
INSERT INTO Recipe_Post VALUES(794613258,5200);
INSERT INTO Recipe_Post VALUES(179346820,5898);

INSERT INTO ShoppingList VALUES('dancing list');
INSERT INTO ShoppingList VALUES('anonymous list');
INSERT INTO ShoppingList VALUES('arbname list');
INSERT INTO ShoppingList VALUES('avengers list');
INSERT INTO ShoppingList VALUES('captain list');

INSERT INTO ShoppingList_Create VALUES('dancing list',1452,'dancing monkey');
INSERT INTO ShoppingList_Create VALUES('anonymous list',5647,'anonymous');
INSERT INTO ShoppingList_Create VALUES('arbname list',3632,'arbname');
INSERT INTO ShoppingList_Create VALUES('avengers list',5200,'avengers step parent');
INSERT INTO ShoppingList_Create VALUES('captain list',5898,'captain canada');

INSERT INTO Favorite VALUES('dmonkey fav');
INSERT INTO Favorite VALUES('meal prep');
INSERT INTO Favorite VALUES('healthy diet');
INSERT INTO Favorite VALUES('fav recipe');
INSERT INTO Favorite VALUES('dessert collection');

INSERT INTO Ingredients VALUES('tomato', 200);
INSERT INTO Ingredients VALUES('chicken breast', 100);
INSERT INTO Ingredients VALUES('oats', 50);
INSERT INTO Ingredients VALUES('lettuce', 200);
INSERT INTO Ingredients VALUES('avocado', 100);
INSERT INTO Ingredients VALUES('tea', 10);
INSERT INTO Ingredients VALUES('beef', 100);
INSERT INTO Ingredients VALUES('shrimp', 100);
INSERT INTO Ingredients VALUES('spaghetti', 50);
INSERT INTO Ingredients VALUES('salt', 1);

INSERT INTO Allergies VALUES('nut');
INSERT INTO Allergies VALUES('diary');
INSERT INTO Allergies VALUES('gluten');
INSERT INTO Allergies VALUES('egg');
INSERT INTO Allergies VALUES('shellfish');

INSERT INTO Category VALUES('Tea Drinks');
INSERT INTO Category VALUES('Coffee Drinks');
INSERT INTO Category VALUES('Cocktails');
INSERT INTO Category VALUES('Juice');
INSERT INTO Category VALUES('Smoothies');
INSERT INTO Category VALUES('CheeseCake');
INSERT INTO Category VALUES('Cookie');
INSERT INTO Category VALUES('Cupcake');
INSERT INTO Category VALUES('IceCream');
INSERT INTO Category VALUES('Pie');
INSERT INTO Category VALUES('Chinese Dishes');
INSERT INTO Category VALUES('Mexican Dishes');
INSERT INTO Category VALUES('Indian Dishes ');
INSERT INTO Category VALUES('Thai Dishes ');
INSERT INTO Category VALUES('Canadian Dishes');
INSERT INTO Category VALUES('15-Minute Meals');
INSERT INTO Category VALUES('Quick Appetizers');
INSERT INTO Category VALUES('Quick Side Dishes');
INSERT INTO Category VALUES('Quick Breakfast');
INSERT INTO Category VALUES('30-Minute Meals');

INSERT INTO Beverage VALUES('Tea Drinks', 0);
INSERT INTO Beverage VALUES('Coffee Drinks', 0);
INSERT INTO Beverage VALUES('Cocktails', 1);
INSERT INTO Beverage VALUES('Juice', 0);
INSERT INTO Beverage VALUES('Smoothies', 0);

INSERT INTO Dessert VALUES('CheeseCake', 1);
INSERT INTO Dessert VALUES('Cookie', 0);
INSERT INTO Dessert VALUES('Cupcake', 1);
INSERT INTO Dessert VALUES('IceCream', 0);
INSERT INTO Dessert VALUES(' Pie', 1);

INSERT INTO Cuisine VALUES('Chinese Dishes', 'China');
INSERT INTO Cuisine VALUES('Mexican Dishes', 'Mexico');
INSERT INTO Cuisine VALUES('Indian Dishes ', 'India');
INSERT INTO Cuisine VALUES('Thai Dishes ', 'Thailand');
INSERT INTO Cuisine VALUES('Canadian Dishes', 'Canada');

INSERT INTO EasyRecipe VALUES('15-Minute Meals', 15);
INSERT INTO EasyRecipe VALUES('Quick Appetizers', 10);
INSERT INTO EasyRecipe VALUES('Quick Side Dishes', 20);
INSERT INTO EasyRecipe VALUES('Quick Breakfast ', 10);
INSERT INTO EasyRecipe VALUES('30-Minute Meals', 30);

INSERT INTO Favorite_Add VALUES('dmonkey fav',1452);
INSERT INTO Favorite_Add VALUES('meal prep',5647);
INSERT INTO Favorite_Add VALUES('healthy diet',3632);
INSERT INTO Favorite_Add VALUES('fav recipe',5200);
INSERT INTO Favorite_Add VALUES('dessert collection',5898);

INSERT INTO Has VALUES('dancing list', 'tomato');
INSERT INTO Has VALUES('anonymous list', 'lettuce');
INSERT INTO Has VALUES('arbname list', 'avocado');
INSERT INTO Has VALUES('avengers list', 'tea');
INSERT INTO Has VALUES('captain list', 'beef');

INSERT INTO Includes VALUES(123456789, 'tomato');
INSERT INTO Includes VALUES(123456789, 'shrimp');
INSERT INTO Includes VALUES(123456789, 'spaghetti');
INSERT INTO Includes VALUES(987654321, 'lettuce');
INSERT INTO Includes VALUES(134679852, 'avocado');
INSERT INTO Includes VALUES(123456789, 'salt');
INSERT INTO Includes VALUES(987654321, 'salt');
INSERT INTO Includes VALUES(134679852, 'salt');
INSERT INTO Includes VALUES(794613258, 'salt');
INSERT INTO Includes VALUES(179346820, 'salt');

INSERT INTO Belong VALUES(123456789, 'Canadian Dishes');
INSERT INTO Belong VALUES(987654321, '30-Minute Meals');
INSERT INTO Belong VALUES(134679852, 'Canadian Dishes');
INSERT INTO Belong VALUES(794613258, 'Tea Drinks');
INSERT INTO Belong VALUES(179346820, 'Canadian Dishes');

INSERT INTO Label VALUES(123456789, 'nut');
INSERT INTO Label VALUES(987654321, 'diary');
INSERT INTO Label VALUES(134679852, 'gluten');
INSERT INTO Label VALUES(794613258, 'diary');
INSERT INTO Label VALUES(179346820, 'gluten');

INSERT INTO Save VALUES(123456789, 'dmonkey fav');
INSERT INTO Save VALUES(987654321, 'meal prep');
INSERT INTO Save VALUES(134679852, 'healthy diet');
INSERT INTO Save VALUES(794613258, 'fav recipe');
INSERT INTO Save VALUES(179346820, 'fav recipe');