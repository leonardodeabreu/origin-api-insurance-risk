# Origin API

Repository hosting the Origin API, for calculating insurance risk.

## Summary

- Project Requirements
- Getting Started
  - Project Cloning & Build
  - Environment Set Up

## Project Requirements

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/gettingstarted)
- [Git](https://git-scm.com/downloads)
- [Postman](https://www.getpostman.com/apps)

## Getting Started
### 1. Project Cloning & Build
  **1.1.** Clone the repository:

  ```
   # git clone git@github.com:leonardodeabreu/origin-api-insurance-risk.git
   # git checkout main
  ```

  **1.2.** Build & Run the project using Docker Container:

  ```
   # docker-compose up --build -d
  ```

### 2. Environment Set Up
  **2.1.** Install dependencies:

  ```
   # docker-compose exec php bash
   # run composer install
  ```

  **2.2.** Run all tests:

  ```
   # docker-compose exec php bash
   # run composer test
  ```

### 3. Docs
  Inside the `docs/postman` folder, you can find the collection and the environment to be imported into postman and use the application.

The Application will run on localhost on port 9090.
