# ShopTherapy
> Application for controlling shopping. Make a list of product or service.
> Live demo [_here_](https://shoptherapy.herokuapp.com/).

## Table of Contents
* [General Info](#general-information)
* [Technologies Used](#technologies-used)
* [Features](#features)<!-- * [Screenshots](#screenshots) -->
* [Setup](#setup)<!-- * [Usage](#usage) -->
* [Project Status](#project-status)  <!-- * [Room for Improvement](#room-for-improvement) * [Acknowledgements](#acknowledgements) --> 
* [Contact](#contact)
* [Source](#source)
<!-- * [License](#license) -->


## General Information
- In this app I want to resolve a problem with a many sticky notes with list of product to buy.
- This project aggregates lists as wishlists, list of shopping, ideas for a present, etc. in one place.
- In this application user collect a information about prices, shops, location of products.
<!--
- Provide general information about your project here.
- What problem does it (intend to) solve?
- What is the purpose of your project?
- Why did you undertake it?
 You don't have to answer all the questions - just the ones relevant to your project. -->


## Technologies Used
- Docker
- NGINX - version 1.21.6-alpine
- PHP - version 8.1.3-fpm-alpine3.15


## Features
List the ready features here:
- Application can display a login and register pages
- Routing is working
- Available view for Mobile, Tablet and PC screens
- Login work
- Database attach
- Session work


## Screenshots
![Login page](./img/login-page.png)
![Login page mobile](./img/login-page-mobile.png)


## Setup
1. You have to install Docker for running this app -> [link](https://www.docker.com/get-started);
2. In the next step please open terminal in main directory of project and provide:
```
docker-compose up
```
- **If you run this at the first time program need more time and Internet connection!**

3. Please wait a moment (program need a time for initialize) and insert in your web browser **http://localhost:8080/**

* To Push on Heroku use this comment on branch *deploy-on-Heroku*:
```
git push heroku dev-ops/deploy-on-Heroku:master
```
**If you have authority for that**

4. You have to set environments in file .env in main catalog with credentials for a database with this schema:
```
SHOPTHERAPY_USERNAME=yourUserNameInDatabaseSystem
SHOPTHERAPY_PASSWORD=passwordForYourDatabase
SHOPTHERAPY_HOST=hostWhereIsYourDataBase
SHOPTHERAPY_DATABASE=databaseName
```
all name without qutoes (" or ')!!!
<!-- What are the project requirements/dependencies? Where are they listed? A requirements.txt or a Pipfile.lock file perhaps? Where is it located?

Proceed to describe how to install / setup one's local environment / get started with the project.
-->

<!-- ## Usage
How does one go about using it?
Provide various use cases and code examples here.

`write-your-code-here` -->


## Project Status
Project is: _in progress_. <!-- If you are no longer working on it, provide reasons why. -->


<!-- ## Room for Improvement
Include areas you believe need improvement / could be improved. Also add TODOs for future development.

Room for improvement:
- Improvement to be done 1
- Improvement to be done 2

To do:
- Feature to be added 1
- Feature to be added 2 -->


<!-- ## Acknowledgements
Give credit here.
- This project was inspired by...
- This project was based on [this tutorial](https://www.example.com).
- Many thanks to... -->


## Contact
Michał Lechowicz <michal.lechowicz@student.pk.edu.pl>
## Source
Readme file was created by [@flynerdpl](https://www.flynerd.pl/)


<!-- Optional -->
<!-- ## License -->
<!-- This project is open source and available under the [... License](). -->

<!-- You don't have to include all sections - just the one's relevant to your project -->
