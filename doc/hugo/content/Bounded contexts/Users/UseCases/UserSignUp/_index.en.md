---
title: "User SignUp"
tags: ["usecase", "users"]
domain_events: ["UserSignedUp", "UserVerificationMailSent", "UserVerificationTimedOut"]
---

{{<imgnewtab src="user-signup-usecase.png" alt="User signIn usecase">}}

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

##### {{<responses status="fail" code="400">}} The user could not be created since there were incorrect parameters

##### {{<responses status="fatal" code="500">}} Fatal error (Has to be controlled)
