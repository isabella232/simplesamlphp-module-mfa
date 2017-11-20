Feature: Prompt for MFA credentials

  Scenario: Don't prompt for MFA
    Given I provide credentials that do not need MFA
    When I login
    Then I should end up at my intended destination

  Scenario: Nag to set up MFA
    Given I provide credentials that will be nagged to set up MFA
    When I login
    Then I should see a message encouraging me to set up MFA
      And there should be a way to go set up MFA now
      And there should be a way to continue to my intended destination

  Scenario: Obeying the nag to set up MFA
    Given I provide credentials that will be nagged to set up MFA
      And I login
    When I click the set-up-MFA button
    Then I should end up at the mfa-setup URL

  Scenario: Ignoring the nag to set up MFA
    Given I provide credentials that will be nagged to set up MFA
      And I login
    When I click the remind-me-later button
    Then I should end up at my intended destination

  Scenario: Needs MFA, but no MFA options are available
    Given I provide credentials that need MFA but have no MFA options available
    When I login
    Then I should see a message that I have to set up MFA
      And there should be a way to go set up MFA now
      And there should NOT be a way to continue to my intended destination

  Scenario: Following the requirement to go set up MFA
    Given I provide credentials that need MFA but have no MFA options available
      And I login
    When I click the set-up-MFA button
    Then I should end up at the mfa-setup URL
      And I should NOT be able to get to my intended destination

  Scenario: Needs MFA, has backup code option available
    Given I provide credentials that need MFA and have backup codes available
    When I login
    Then I should see a prompt for a backup code

  Scenario: Needs MFA, has TOTP option available
    Given I provide credentials that need MFA and have TOTP available
    When I login
    Then I should see a prompt for a TOTP code

  Scenario: Needs MFA, has U2F option available
    Given I provide credentials that need MFA and have U2F available
    When I login
    Then I should see a prompt for a U2F security key

  Scenario: Accepting a (non-rate-limited) correct MFA value
    Given I provide credentials that need MFA and have backup codes available
      And I have logged in
    When I submit a correct backup code
    Then I should end up at my intended destination

  Scenario: Rejecting a (non-rate-limited) wrong MFA value
    Given I provide credentials that need MFA and have backup codes available
      And I have logged in
    When I submit an incorrect backup code
    Then I should see a message that it was incorrect

  Scenario: Blocking an incorrect MFA value while rate-limited
    Given I provide credentials that have a rate-limited MFA
      And I have logged in
    When I submit an incorrect backup code
    Then I should see a message that I have to wait before trying again

  Scenario: Blocking a correct MFA value while rate-limited
    Given I provide credentials that have a rate-limited MFA
      And I have logged in
    When I submit a correct backup code
    Then I should see a message that I have to wait before trying again
