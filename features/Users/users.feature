
Feature:
    Users use cases

    As a User I want to signUp and Login to the platform using the API

    @fixtures
    Scenario: SignUp User
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "JohnDoe",
            "email": "test.email@gmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 200
        And should be equal to:
        """
          {
            "id": "73f2791e-eaa7-4f81-a8cc-7cc601cda30e",
            "userName": "JohnDoe",
            "email": "test.email@gmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """

    Scenario: SignUp User but email exists in database
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "JohnDoe",
            "email": "test.email@gmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 400
        And the response should contain:
        """
        "email is in use"
        """

    Scenario: SignUp User but username exists in database
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "JohnDoe",
            "email": "test.email2@gmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 400
        And the response should contain:
        """
        "email is in use"
        """

    Scenario: SignUp User with invalid user and return 400 status code
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "",
            "email": "test.emailgmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 400
        And the response should contain:
        """
        "Username invalid by policy rules"
        """

    Scenario: SignUp User with invalid email and return 400 status code
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "JohnDoe",
            "email": "test.emailgmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 400
        And the response should contain:
        """
        "Invalid Email format"
        """

    Scenario: SignUp User with invalid password  and return 400 status code
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "JohnDoe",
            "email": "test.email@gmail.com",
            "password": ",&+3Rj"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 400
        And the response should contain:
        """
        "Password invalid by policy rules"
        """