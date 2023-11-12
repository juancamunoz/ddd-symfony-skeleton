<?php

namespace App\Tests\Acceptance\SharedKernel;

use App\Tests\Acceptance\SharedKernel\Infrastructure\JwtTokenMother;
use Assert\Assertion;
use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use SebastianBergmann\Diff\Differ;
use Symfony\Component\HttpFoundation\HeaderBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class SharedContext implements Context
{
    private ?Response $response;
    private HeaderBag $headers;

    public function __construct(private readonly KernelInterface $kernel, private readonly string $base64RsaKey)
    {
        $this->headers = new HeaderBag();
    }

    /**
     * @When I send a :method request to :path
     */
    public function iSendARequestTo(string $method, string $path): void
    {
        $request = Request::create($path, $method);

        $request->headers->replace($this->headers->all());

        $this->response = $this->kernel->handle($request);
    }

    /**
     * @Then the response JSON should be equal to:
     */
    public function theResponseJSONShouldBeEqualTo(PyStringNode $responseContent): void
    {
        $expected = json_encode(json_decode((string) $responseContent), JSON_PRETTY_PRINT);
        $actual = json_encode(json_decode($this->response->getContent(), true), JSON_PRETTY_PRINT);

        if ($expected === $actual) {
            return;
        }

        Assertion::eq(
            $expected,
            $actual,
            "JSON's are not equal: \n" . (new Differ())->diff($expected, $actual)
        );
    }

    /**
     * @Then the status code should be :statusCode
     */
    public function theStatusCodeShouldBe(int $statusCode): void
    {
        if ($this->response->getStatusCode() !== $statusCode) {
            throw new \RuntimeException(sprintf('Expected status code %s and got %s', $statusCode, $this->response->getStatusCode()));
        }
    }

    /**
     * @When I add a jwt token with admin user role
     */
    public function iAddAJwtTokenWithAdminUserRole(): void
    {
        $this->headers->set('Authorization', sprintf('Bearer %s', JwtTokenMother::withAdminRole()));
    }
}
