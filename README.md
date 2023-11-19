# whatsapp-web-clone-with-php-backend
Cloning Whatsapp Web application using PHP and WebSocket

The aim of this project was to challenge my self by making a web application like Whatsapp Web and more importantly to make it easy to deploy and run using Docker.


## Overview

This project is built using a combination of technologies to ensure a robust and scalable application. Here's a brief overview of the tech stack and tools we use:

- **Backend**: PHP 8.2 with MySQL for database.
- **Server**: Apache2
- **Database Management**: PhpMyAdmin
- **CLI Tool**: I use `make` as my command line handler tool for executing repetitive tasks efficiently.
- **IDE**: Visual Studio Code

All this services are running inside Docker containers.


## Installation

Before following the installation steps, ensure you have the following software installed:  
- Docker
- `make` (Installation varies based on your OS. For most Linux distributions, it's available by default.)

#### Step 1:  Clone the project  
I think you can clone this project easily like a great developer. So join me in [step 2](#step-2-configure-your-environment)

#### Step 2: Configure your environment  
You have to create a `.env` file in the root of the project. The content of the `.env` file newly created must be the same as the `.env.example` file.  
Now you can replace the value of the following variable as you want:  
- `MYSQL_USER`
- `MYSQL_PASSWORD`  

#### Step 3: Build the project  
To build the project you need to run just one command:

> `make build`  

This command sets up the project using Docker Compose. It builds the local Dockerfile and applies all the rules defined in the `docker-compose.yml` file.  


## Access the project  

Now that you have followed all the steps to build the project, open your browser and navigate to the [Whatsapp Web Clone](http://localhost:8080).
