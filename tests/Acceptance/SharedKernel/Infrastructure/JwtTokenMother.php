<?php

namespace App\Tests\Acceptance\SharedKernel\Infrastructure;

use Lcobucci\JWT\Encoding\ChainedFormatter;
use Lcobucci\JWT\Encoding\JoseEncoder;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Token\Builder;

class JwtTokenMother
{
    private const BASE_64_SIGNER_KEY = 'LS0tLS1CRUdJTiBSU0EgUFJJVkFURSBLRVktLS0tLQ0KTUlJRXBBSUJBQUtDQVFFQTQzMVRGUW1iTTNNUERaaFJFQzhOTG9ySVFwa0lwU3FYeWFnemhBNnpBOHBMU0RIUA0KY0dmM2JaZi92OVRxTWJRMVdkN3YrUlJ0NDhtNWpiVjhFVjEzUFhRZnNiTXJybUtmK0NWZHRJWXh5ci9hMGcrOA0KK25SZGFkbVZUMm8rcnJlWjlhWkU4dHc5M1J2WWdpNmdRYzYvNEtjLzkrbU9Zb2hjemZVSjhVUkJ1QkhiOVcxZg0KcndQQzNKSS9BaXhsakdoSG84RFNBWWY0cXVuYXp2RFhIMnJRWENVMC9tOERPd09abGRNYzU3TStndG1HVFlBag0KRWRzUXJsUDVYWXhZMkpoT0ZyWHh3bHNJWjMzaHlxS1dpSVk5TkdZdXVXbjRYTFRBUHlUY2tVb2xKUXlNdU04TA0KV1BWYjBTV05FZUp2eXRvMzY2blZtU1lmZnNXdFdZQXhnbHI0RndJREFRQUJBb0lCQUFxSUVNS1drVUxPZnRIbw0KVFVoc2hUVzBZeFVDTks1QXpJb2ZhVk1od3hQWDE2aGQ5ZmFFT2FZdk5UM1NRNDFOaEhMR3FXRmttcm5DNnY0dQ0KZXJIckc4d1NoaTBaMkZuWVl3Ti81MWltSmNQM0lkQTd2a254L1NrYlU1ZzdtTzlKdkt6c3A2QitwYmFJeFhzeA0KWVdYcWhtT0dHcVlGZi92N3lDQVl5ZjhMWStkN2hkRzJWRlRvb0o3dDRESjFNVUVyWmY3STRLK2N4L1VwSnBOKw0KZ1dGelI0ckFrMEVtTitJL1F6K1lxOXJ3bEVEeDFoWGo2TURIR3BUc00wMmVFelcrY0hZejdJeG11VUc5K1ZnUw0KNFFsaTYvTFhpbjNpOUJrM0QvMnl3QWdKNEpDSjFKcXprTGpLM1ZjcFlXdEdhRTlEK0hRMTU1M0Ftd2kwY29pVg0KRjVQQ08wRUNnWUVBK2VVWU4vQlpRUWJTL3cxcXhyZy9KN1BwcnJ1eTJaQWNQeG5qVVB5aWVDazBVb0l3SGE0TA0KMlVsMi8rc2czU0NwM3BLMWliY1JWZFZQMlZlUjdib3o3d1BqRG1ReE9TamRJcFRZdzJ1NkNsQit3bFAzUjkwaA0KOGhpYVp4dlZvYklJTjc0b1JZOThvUGMrTFEzMGhtM083ZU1IMWdYRkFjVHB3aUgva25aUUIwY0NnWUVBNlF3Wg0KNnpueHd0ZTY3NW5aY0dRTmhRRlJNUkc3Z2RTdE9zbTM1RTN0ampLWDgySk5Vb2JMdjdnelVpMU9HbURVR29GcQ0KV3R1UE9lcldpdHd0L01UUU1Cc1BhRkdSZEJQL2ZyMzBRY3IwbGs1dVVHNXdWQUhBOFMvdHRZVFJ5SnA0MkRtVg0KR2lKRmF0d0phaFhVK0pReis0dzdFcXlCU0NRM3lRcWxPanFpa0xFQ2dZRUF0RmRnNHYzUmE5eEE2VkFGZnVQNA0Kcis1bTluTCszNFBnM3FrUUk2SXVuZ2tlZVd6NnpIQ09uSUVvSUFqUDdzVmowZnlPaHBSWExscURCWmJzK1dNbg0KbDVaMmhpeElXYmZqM3RFTW5mdGdoNUVQNmE0dkJ1M1BVYWZ2eGZtUWN1RElqWEh1SGtVdTYvdUNJNEd1dGxVSQ0Kd1NUV3d0M25EeC9Na3cxMkkzeSt4SUVDZ1lBczZJVVNIQjluY1pUM1dRbGFyQjBpMVVjbEVvcTBrUncwcU95RA0KMVRTQzQyTCtwcUhKMW1ucTd2OE14ZWc0RXhLc2JPWG16a3FDV2F1d0pJL0VGdFViZ0F0dkNkRGlzbnZZbTVnMw0KR1hvYWdOQ25OVEQyTDBSVDllMXp2ajJDejZtYjJUVFBUVzFkRXp2Sk1wM1FyUlo3VWVHTVRxdTNFQ3VqMVNaVA0KMnpxNmNRS0JnUUNTOE1rd2l2YTNtVDlEZ2hzemNtdWNjV1JlV0ZMcDczaWlnOFZFSnN4LytxcnFpbmhsTHZSbA0KWUxyOVFvejBDK3NzV1ZpYThETW1vQ0pMRVhTaHdiQmtuTitOTmtpOEFyenVKWnlEamNRRGt5bkZITFRsUkpVKw0KSGk3ZG1TWGtoUm5KU3lrZC9LZXduc05EVjVwMXNKUjVqR0syL285SXdRMnYvNktqK1ZlWVBRPT0NCi0tLS0tRU5EIFJTQSBQUklWQVRFIEtFWS0tLS0t';

    public static function create(array $claims): string
    {
        $tokenBuilder = new Builder(new JoseEncoder(), ChainedFormatter::default());
        $tokenBuilder = $tokenBuilder
            ->withHeader('alg', 'RS256')
            ->withHeader('typ', 'JWT');

        foreach ($claims as $key => $value) {
            $tokenBuilder = $tokenBuilder->withClaim($key, $value);
        }

        return $tokenBuilder->getToken(
            new Sha256(),
            InMemory::base64Encoded(self::BASE_64_SIGNER_KEY)
        )->toString();
    }

    public static function withAdminRole(): string
    {
        return self::create([
            'preferred_username' => 'test@test.com',
            'realm_access' => [
                'roles' => [
                    'ROLE_ADMIN'
                ]
            ]
        ]);
    }
}
