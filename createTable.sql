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

CREATE TABLE ShoppingList_Create (
ShoppingListName        VARCHAR2(30),
ID            		    INTEGER,
PRIMARY KEY (ShoppingListName),
FOREIGN KEY (ID) REFERENCES Member,
UNIQUE (ID));
 
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

CREATE TABLE ShoppingList(
ShoppingListName    VARCHAR2(30)  PRIMARY KEY);

CREATE TABLE Recipe(
RecipeID	 INTEGER  PRIMARY KEY,
UserName	 VARCHAR2(30), 
RecipeName	 VARCHAR2(15), 
Difficulty	 INTEGER, 
Instruction	 VARCHAR2(300),
Time	 	 INTEGER);

CREATE TABLE Include(
RecipeID      	 INTEGER,
IngredientName	 VARCHAR2(30),
PRIMARY KEY (RecipeID, IngredientName)
FOREIGN KEY (RecipeID) REFERENCES Recipe,
FOREIGN KEY (IngredientName) REFERENCES Ingredients);

CREATE TABLE Belong(
RecipeID      	 INTEGER,
CategoryName	 VARCHAR2(30),
 PRIMARY KEY (RecipeID, CategoryName),
 FOREIGN KEY (RecipeID) REFERENCES Recipe,
 FOREIGN KEY (CategoryName) REFERENCES Beverage, Dessert, Cuisine, EasyRecipe);

CREATE TABLE Label(
RecipeID        	INTEGER,
AllergyName	VARCHAR2(30),
 PRIMARY KEY (RecipeID, AllergyName)
 FOREIGN KEY (RecipeID) REFERENCES Recipe,
 FOREIGN KEY (AllergyName) REFERENCES Allergies);

CREATE TABLE Save(
RecipeID      	 INTEGER,
CollectionName	 VARCHAR2(30),
 PRIMARY KEY (RecipeID, CollectionName)
 FOREIGN KEY (RecipeID) REFERENCES Recipe ON DELETE CASCADE,
 FOREIGN KEY (CollectionName) REFERENCES Favorite);

CREAT TABLE Favorite(
CollectionName       VARCHAR2    PRIMARY KEY);
         
CREATE TABLE Ingredients(
IngredientName	VARCHAR2(30) 	PRIMARY KEY,
Weight      		 INTEGER);

CREATE TABLE Allergies(
 AllergyName	VARCHAR2(30) 	PRIMARY KEY);


CREATE TABLE Beverage(
CategoryName       VARCHAR2(30)        PRIMARY KEY,
Alcohol     INTEGER);

CREATE TABLE Dessert(
CategoryName    VARCHAR2(30)        PRIMARY KEY,
Keto    		INTEGER
);

CREATE TABLE Cuisine(
CategoryName       VARCHAR2(30)        PRIMARY KEY,
Region      	    VARCHAR2(30)
);

CREATE TABLE EasyRecipe(
CategoryName       VARCHAR2(30)        PRIMARY KEY,
Time      	       INTEGER
);

