
Feature:
  Users use cases

  As a User I want to signUp and Login to the platform using the API

  Scenario: SignUp User
    When I send a "POST" request to "/users" with values:
    """
      {
        "userName": "JohnDoe",
        "email": "test.email@gmail.com",
        "password": ",&+3RjwAu88(tyC'"
      }
    """
    Then the response should be received
