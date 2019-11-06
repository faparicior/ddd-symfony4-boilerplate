
Feature:
    Users use cases

    As a User I want to signUp and Login to the platform using the API

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
        And should be equal to:
        """
          {
            "id": "73f2791e-eaa7-4f81-a8cc-7cc601cda30e",
            "userName": "JohnDoe",
            "email": "test.email@gmail.com",
            "password": ",&+3RjwAu88(tyC'"
          }
        """
