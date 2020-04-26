---
title: "User SignUp"
tags: ["usecase", "users"]
domain_events: ["UserSignedUp", "UserVerificationMailSent", "UserVerificationTimedOut"]
business_rules: ["User email is unique"]
---

{{<imgnewtab src="user-signup-usecase.png" alt="User signUp usecase">}}

### Calls
---

#### {{<oplockcall src="POST">}} /users
```json
{
    "id": "73f2791e-eaa7-4f81-a8cc-7cc601cda30e",
    "userName": "JohnDoe",
    "email": "test.email@gmail.com",
    "password": ",&+3RjwAu88(tyC'"
}
```

### Responses
---

##### {{<responses status="ok" code="201">}} The user has been created successfully
```json
{
    "id": "73f2791e-eaa7-4f81-a8cc-7cc601cda30e"
}
```

##### {{<responses code="400">}} The user could not be created since there were incorrect parameters

##### {{<responses code="500">}} Fatal error (Has to be controlled)

### User interface
---

#### User SignUp

{{<imgnewtab src="ui-signup-1.png" alt="User signUp">}}

#### User verification mail

[TODO: Add mailing text]
