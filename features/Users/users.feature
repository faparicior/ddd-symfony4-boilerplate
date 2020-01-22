
Feature:
    Users use cases

    As a User I want to signUp and Login to the platform using the API

    @fixtures
#        TODO!!!: Fixtures has to clean user database and related tables in a easy way to function
    Scenario: SignUp User
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "JohnDoe",
            "email": "test.email@gmail.com",
            "password": ",\u0026+3RjwAu88(tyC\u0027"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 200
        And the response should have:
        """
            "userName": "JohnDoe",
            "email": "test.email@gmail.com",
            "password": ",\u0026+3RjwAu88(tyC\u0027"
          }
        """

    Scenario: SignUp User but email exists in database
        When I send a "POST" request to "/users" with body:
        """
          {
            "userName": "JohnDoe2",
            "email": "test.email@gmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """
        Then the response content should be in JSON
        And the response status code should be 400
        And the response should contain:
        """
        "User email is in use"
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
        "UserName is in use"
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