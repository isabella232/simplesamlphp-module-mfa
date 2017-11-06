<?php
namespace Sil\SspMfa\Behat\fakes;

/**
 * FAKE IdP ID Broker API client, used for testing.
 */
class FakeIdBrokerClient
{
    const CORRECT_VALUE = '111111';
    const INCORRECT_VALUE = '999999';
    
    /**
     * Constructor.
     *
     * @param string $baseUri - The base of the API's URL.
     *     Example: 'https://api.example.com/'.
     * @param string $accessToken - Your authorization access (bearer) token.
     * @param array $config - Any other configuration settings.
     */
    public function __construct(
        string $baseUri,
        string $accessToken,
        array $config = []
    ) {
        // No-op
    }

    /**
     * Verify an MFA value
     * @param int $id
     * @param string $value
     * @return bool
     */
    public function mfaVerify($id, $employeeId, $value)
    {
        return ($value === self::CORRECT_VALUE);
    }
}
