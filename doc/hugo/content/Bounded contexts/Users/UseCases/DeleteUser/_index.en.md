---
title: "Delete User"
tags: ["usecase", "users"]
domain_events: ["UserDeleted"]
business_rules: ["User is the same as logged"]
---

{{<imgnewtab src="delete-user-usecase.png" alt="User signIn usecase"  srcfile="delete-user-usecase.graphml">}}

### Calls
---

### [FIXME] Review calls
#### {{<oplockcall src="DELETE">}} /users
```json
{
    "email": "test.email@gmail.com"
}
```

### Responses
---

##### {{<responses code="200">}}  There's a user that matches with the given email and has been deleted

##### {{<responses code="400">}} Invalid email supplied
```json
"User not found"
```

### User interface
---

#### Delete user
### [FIXME] UI needed
