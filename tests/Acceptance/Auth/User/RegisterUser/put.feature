Feature:
  In order to register new users
  I want to make sure that the API provide this functionality

  Scenario: Register a new user
    And I send a PUT request to '/auth/user/5bf77501-95ae-44f2-b624-68e0dc5c6e34' with body:
    """
    {
      "email": "test2@test.com"
    }
    """
    Then the status code should be 201
