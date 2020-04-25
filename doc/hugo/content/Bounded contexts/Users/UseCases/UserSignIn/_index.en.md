---
title: "User SignIn"
tags: ["usecase", "users"]
domain_events: ["UserSignedIn"]
---

{{<imgnewtab src="user-signin-usecase.png" alt="User signIn usecase">}}

### Calls
---

### [FIXME] Review calls
#### {{<oplockcall src="POST">}} /users/login
```json
{
    "email": "test.email@gmail.com",
    "password": ",&+3RjwAu88(tyC'"
}
```

### Responses
---

##### {{<responses status="ok" code="200">}}  There's a user that matches with the given email and password
```json
{
    "email": "test.email@gmail.com"
}
```

##### {{<responses status="fail" code="400">}} Invalid username/password supplied

### User interface
---

#### User SignIn

{{<imgnewtab src="ui-signin-1.png" alt="User signUp">}}
