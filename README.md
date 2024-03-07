## Get Started

This guide will walk you through the steps needed to get this project up and running on your local machine.

### Prerequisites

Before you begin, ensure you have the following installed:

- Docker
- Docker Compose

### Building the Docker Environment

Build and start the containers:

```
docker-compose up -d --build
```

### Installing Dependencies

```
docker-compose exec app sh
composer install
```

### Database Setup

Set up the database:

```
bin/cake migrations migrate
```

### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

- Please use Postman on PC to check application

### Authentication

Sample User info created by Seeding:

```
email: "admin@admin.com"
password: "123456"
```

```
email: "user@user.com"
password: "123456"
```

Login to get token for Authentication

```
method POST: http://localhost:34251/api/users/login.json
    body {"email": "admin@admin.com", "password": "123456"}
```


<img src="https://img001.prntscr.com/file/img001/VZd4ve0JQ0W6LPRd05sLZA.png" alt="Login" style="width:800px;"/>

#### Get the token from user data response to setup Authorization in Postman
1. Select tab Authorization in Postman
2. Chose Type "API key"
3. On the right side, config following:
- Add value "Token" for "Key" input
- Add token from login user data response above for "Value" input
- Chose "Header" for "Add to" Selection

<img src="https://img001.prntscr.com/file/img001/9Ap6mApnSzCCHY-Zm2k9CQ.png" alt="Authentication setup" style="width:800px;"/>

### Article Management

1. #### Getting list articles

- Permission: All user.

1. Select tab Authorization in Postman
2. Chose Type "API key"

```
method GET: http://localhost:34251/api/articles.json
```

<img src="https://img001.prntscr.com/file/img001/g7IMfqvkRNSs5lu4bD3bXA.png" alt="Authentication setup" style="width:800px;"/>


2. ####  Get detail article by id

- Permission: All user.

1. Select tab Authorization in Postman
2. Chose Type "API key"

```
method GET: http://localhost:34251/api/articles/1.json
```

<img src="https://img001.prntscr.com/file/img001/mZV2HlTkSEywYoMTvFyXiA.png" alt="Authentication setup" style="width:800px;"/>


3. ####  Create an article

- Permission: Authenticated users.

- Case 1: authenticated user ( require login )

```
method POST: http://localhost:34251/api/articles.json
    body {"title": "authenticated user title", "body": "authenticated user body"}
```

Response: 200. an article object created successfully.

- Case 2: Not authenticated user ( logout first by Logout API = GET: http://localhost:34251/api/users/logout.json)

```
method POST: http://localhost:34251/api/articles.json
    body {"title": "Not authenticated user Title", "body": "Not authenticated user Body"}
```

Response: 401 "Authentication is required to continue",

- Case 3: no body param

```
method POST: http://localhost:34251/api/articles.json
```

Response: 200: "Error when create article."







