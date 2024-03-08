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

Set up the sample:

```
bin/cake migrations seed 
```


### Accessing the Application

The application should now be accessible at http://localhost:34251

## How to check

- Please use Postman on PC to check application

### Authentication

Sample User info created by Seeding:

```
email: "admin@vti.com"
password: "123456"
```

```
email: "user@vti.com"
password: "123456"
```

Login to get token for Authentication

```
method POST: http://localhost:34251/api/users/login.json
    body {"email": "admin@vti.com", "password": "123456"}
```


<img src="https://img001.prntscr.com/file/img001/2OD2bpJKS4qWceqDjMDaNA.png" alt="Login" style="width:800px;"/>

#### Get the token from user data response to setup Authorization in Postman
1. Select tab Authorization in Postman
2. Chose Type "API key"
3. On the right side, config following:
- Add value "Token" for "Key" input
- Add token from login user data response above for "Value" input
- Chose "Header" for "Add to" Selection

<img src="https://img001.prntscr.com/file/img001/IYV714cFSE2iL0k26vGi4A.png" alt="Authentication setup" style="width:800px;"/>

### Article Management

1. #### Getting list articles

- Permission: All user.

1. Select tab Authorization in Postman
2. Chose Type "API key"

```
method GET: http://localhost:34251/api/articles.json
```

<img src="https://img001.prntscr.com/file/img001/EltykyPAS3CmpQdQyhPpaA.png" alt="Authentication setup" style="width:800px;"/>


2. ####  Get detail article by id

- Permission: All user.

1. Select tab Authorization in Postman
2. Chose Type "API key"

```
method GET: http://localhost:34251/api/articles/1.json
```

<img src="https://img001.prntscr.com/file/img001/2kjn_LRZS8C6O3oYKcnu6A.png" alt="Authentication setup" style="width:800px;"/>


3. ####  Create an article

- Permission: Authenticated users.

- Case 1: authenticated user ( require login )

```
method POST: http://localhost:34251/api/articles.json
    body {"title": "authenticated user title", "body": "authenticated user body"}
```

<img src="https://img001.prntscr.com/file/img001/XbKewZiSRteIsnYr_4ZOFQ.png" alt="Authentication setup" style="width:800px;"/>

Response: 200. an article object created successfully.

- Case 2: Not authenticated user ( logout first by Logout API = GET: http://localhost:34251/api/users/logout.json)

```
method POST: http://localhost:34251/api/articles.json
    body {"title": "Not authenticated user Title", "body": "Not authenticated user Body"}
```

<img src="https://img001.prntscr.com/file/img001/TKv9BlxkSyes5e2p-bfWJg.png" alt="Authentication setup" style="width:800px;"/>


Response: 401 "Authentication is required to continue",

- Case 3: no body param

```
method POST: http://localhost:34251/api/articles.json
```

<img src="https://img001.prntscr.com/file/img001/DhYI6Um5QjmUbfOKOu8N1w.png" alt="Authentication setup" style="width:800px;"/>


Response: 200: "Error when create article."

4. ####  Edit an article

- Permission: Authenticated users & article writer users.

- Case 1: authenticated user and the writer (require login by user 'admin@vti.com') 

```
method PUT: http://localhost:34251/api/articles/1.json
    {"title": "updated my post title", "body": "updated my post body"}
```

<img src="https://img001.prntscr.com/file/img001/Jd0RUWCxRWu2DbznuTLvKQ.png" alt="Authentication setup" style="width:800px;"/>


Response: 200. "Updated article successfully"

- Case 2: authenticated user and NOT the writer (require login by user 'user@user.com').

```
method PUT: http://localhost:34251/api/articles/2.json
    {"title": "updated other writer title", "body": "updated other writer body"}
```

<img src="https://img001.prntscr.com/file/img001/8yOqJ_I8T5asXrFu00a_2w.png" alt="Authentication setup" style="width:800px;"/>

Response: 401. "Unauthorized. You have no - Permission",

- Case 3: Not authenticated user ( require logout = GET: http://localhost:34251/api/users/logout.json)

```
method PUT: http://localhost:34251/api/articles/2.json
    {"title": "Not authenticated user title", "body": "Not authenticated user body"}
```

<img src="https://img001.prntscr.com/file/img001/RTqtJxXORDaXvXxIFWnmPg.png" alt="Authentication setup" style="width:800px;"/>


Response: 401. "Authentication is required to continue",


5. ####  Delete an article

- Permission: Authenticated users & article writer users.

- Case 1: authenticated user and the writer (require login by user 'admin@vti.com') 

```
method DELETE: http://localhost:34251/api/articles/1.json
```

<img src="https://img001.prntscr.com/file/img001/Qk5W1JPyRaq9kh9QtOettQ.png" alt="Authentication setup" style="width:800px;"/>


Response: 200. "Deleted article successfully"

- Case 2: authenticated user and NOT the writer (require login by user 'user@vti.com').

```
method DELETE: http://localhost:34251/api/articles/2.json
```

<img src="https://img001.prntscr.com/file/img001/5oSRGI2CR6KVGHc_3Gj8Cw.png" alt="Authentication setup" style="width:800px;"/>


Response: 401. "Unauthorized. You have no - Permission",

- Case 3: Not authenticated user ( require logout )

```
method DELETE: http://localhost:34251/api/articles/1.json
```

<img src="https://img001.prntscr.com/file/img001/YuAiKg0LS16vJA7NHET5yg.png" alt="Authentication setup" style="width:800px;"/>


Response: 401. "Authentication is required to continue",

### Like Feature

1. ####  Like an article

- Permission: Authenticated users     

- Case 1: authenticated user (require login) 

```
method GET: http://localhost:34251/api/articles/like/10.json
```

<img src="https://img001.prntscr.com/file/img001/xKuy-WfgTeqCEYqGGRjmUw.png" alt="Authentication setup" style="width:800px;"/>


Response: 200. "You have liked this article successfully"

- Case 2: authenticated user & liked article (require login) 

```
method GET: http://localhost:34251/api/articles/like/10.json
```

<img src="https://img001.prntscr.com/file/img001/z3ElKKNsTJiIazxxJIpAlw.png" alt="Authentication setup" style="width:800px;"/>

Response: 200. "You liked this article before"

- Case 3: Not authenticated user

```
method GET: http://localhost:34251/api/articles/like/10.json
```

<img src="https://img001.prntscr.com/file/img001/yh_khLAYSzmNHUJxblalPA.png" alt="Authentication setup" style="width:800px;"/>


Response: 401. "Authentication is required to continue"

2. ####  View like count 

- Permission: All user 

- Case 1: detail article

```
method GET: http://localhost:34251/api/articles/6.json
```

<img src="https://img001.prntscr.com/file/img001/ks6Xx9FuS8epzVycDNJSmg.png" alt="Authentication setup" style="width:800px;"/>


Response: an article object with "like_count" field

- Case 2: list article

```
method GET: http://localhost:34251/api/articles.json
```

<img src="https://img001.prntscr.com/file/img001/PKBOt6B5TVSmvDr6vftzfg.png" alt="Authentication setup" style="width:800px;"/>


Response: an array of articles object with "like_count" field

### Common

- Not found article

```
method GET: http://localhost:34251/api/articles/99.json
method PUT: http://localhost:34251/api/articles/99.json
method DELETE: http://localhost:34251/api/articles/99.json
method GET: http://localhost:34251/api/articles/like/99.json

```

Response: "Record not found in table \"articles\"",








