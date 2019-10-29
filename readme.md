# Giftano API Test

## Project Requirement
Create a REST API with CRUD with required features:
1. list items
2. add item
3. update item
4. delete item

# Setup Project On Your Local Machine

## Prerequisites
1. Apache Web Server
2. PHP 7.2
3. Composer
4. MySQL
5. Git

## Setup Guide
1. Make sure you install all the Prerequisite
2. Clone the project from github to your directory

`git@github.com:tyanosaurusrex/giftano-api-test.git`

3. Install the dependencies using this command

`composer install`

4. Copy the env.example file and rename the new one with .env. Update if needed

5. Setup the database by create new database on you local machine, and run these commands

`php artisan migrate`
`php artisan db:seed`

6. Run the project using this command

`php artisan serve`

and the project will be running on `http://localhost:8000`

7. Run testing using this command

`vendor/bin/phpunit`

# API List

## Categories /api/categories/

**Show all categories**
> GET /api/categories

**Create New category**
> POST /api/categories

Body:
```
{
	"name": "Category B",
	"parent": 0, 
}
```

**Update Category**
> PUT /api/categories/{id}

Body:
```
{
	"name": "Category B",
	"parent": 0,
}
```

**Delete Category**
> DELETE /api/categories/{id}

## Item /api/items/

**Show all items**
> GET /api/items

**Create New item**
> POST /api/items

Body:
```
{
	"name": "Item B",
	"category_id": 4, 
}
```

**Update Item**
> PUT /api/items/{id}

Body:
```
{
	"name": "Item B",
	"category_id": 4, 
}
```

**Delete Item**
> DELETE /api/items/{id}
