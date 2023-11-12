Feature:
  In order to prove that the current API is working
  I want to make sure that the API health check is OK

  Scenario: Health check status is OK
    When I send a GET request to "/health-check"
    Then the response JSON should be equal to:
    """
    {
      "data": {
        "status": "ok"
      }
    }
    """
    And the status code should be 200
