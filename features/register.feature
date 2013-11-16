# features/register.feature
Feature: Register
  In order to create an account
  As a user
  I need to be able to submit my details using a registration form

Scenario: Access the registration via Get Started button on homepage
  Given I am on the homepage
  When I follow "Get started"
  Then I should see "Your username"

Scenario: Access the registration form when not on homepage
  Given I am on the help page
  When I follow "Register"
  Then I should see "Your username"
  
Scenario: Submit user registration details with mismatched passwords
  Given I am on the registration page
  When I fill in "username" with "Chrismo"
  And I fill in "email" with "chris12@chrismo.com"
  And I fill in "password" with "asdasd12"
  But I fill in "confirmpassword" with "adsasd11"
  And I press "Create My Account"
  Then I should see "Passwords don't match"
  
