Feature:
  In order to search users by filter
  I want to make sure that the API provide this functionality

  Scenario: Search users by email
    When I add a jwt token with admin user role
    And I send a GET request to "/api/user?email=jcmc324@gmail.com"
    Then the response JSON should be equal to:
    """
    {
      "data": {
        "id": "636da888-b16d-485c-a0bd-cf506a376a0e",
        "email": "jcmc324@gmail.com"
      }
    }
    """
    And the status code should be 200
